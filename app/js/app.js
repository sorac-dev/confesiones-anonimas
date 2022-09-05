/* flag = true;
$(window).scroll(function() {
if($(window).scrollTop() + $(window).height() == $(document).height()){
first = $('#first').val();
limit = $('#limit').val();
no_data = true;
if(flag && no_data){
    flag = false;
    $('#loader').show();
    $.ajax({
        url : 'ajax.php',
        dataType: "json",
        method: 'post',
        data: {
           start : first,
           limit : limit
        },
        success: function( data ) {
            flag = true;
            $('#loader').hide();
            if(data.count > 0 ){
                first = parseInt($('#first').val());
                limit = parseInt($('#limit').val());
                $('#first').val( first+limit );
                $('#timeline-container');
                $.each(data.content, function(key, value ){

                    if(value.event!=''){
                    html = '<li class="timeline-item">';
                    html += '<div class="timeline-badge" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="Mention"><a href="#"></a></div>';
                    html += '<div class="timeline-panel">';
                    html += '<div class="timeline-heading">';
                    html += '<p>This is the new post: </p>';
                    html += '<div class="timeline-date"><i class="fa fa-calendar-o"></i> '+value.date+'</div>';
                    html += '</div>';
                    html += '<div class="timeline-content">';
                    html += '<p>'+value.post+'</p>';
                    html += '</div>';
                    html += '</li>';
                    }

                    $('#timeline-container').append( html );

                    $('.timeline-item').waypoint({
                        triggerOnce: true,
                        offset: '80%',
                        handler: function() {
                            jQuery(this).addClass('animated fadeInUp');
                        }
                    });
                });
            }else{
                alert('No more data to show');
                no_data = false;
            }
        },
        error: function( data ){
            flag = true;
            $('#loader').hide();
            no_data = false;
            alert('Something went wrong, Please contact admin');
        }
    });
}}}); */
const on = (typeevent, el, callback) => {
  el.addEventListener(typeevent, (e) => callback(e));
};

const getMoreData = (desde = 0, total = 10) => {
  (() => {
    $confesiones = $(`[data-result="confesiones"]`);
    $no_more_results = $(`[data-result="no-more-results"]`);
    fetch(`/core/getMoreData.php?desde=${desde}&total=${total}`)
      .then((r) => r.json())
      .then((response) => {
        if (response.code === 200) {
          response.data.forEach(
            ({
              id,
              id_conf,
              edad,
              genero,
              confesion,
              date_conf,
              time_conf,
              pais,
              ip_user,
            }) => {
              const ifGenero =
                genero === "2"
                  ? "user-secret"
                  : genero === "3"
                  ? "female"
                  : genero === "4"
                  ? "male"
                  : "";
              const ifDisabled =
                genero === "2"
                  ? "style='display:none;'"
                  : genero === "3"
                  ? ""
                  : genero === "4"
                  ? ""
                  : "";

              $confesiones.append(`<div class="conf-separador"></div>
        <div class="container-conf" id-confesion="${id_conf}">
            <div class="div-confesion-${ifGenero}">
                <div class="conf-head-${ifGenero}">
                    <div class="conf-edad-h aling-left">
                        <i class="fa fa-${ifGenero}" aria-hidden="true"></i><span> ${edad} </span>años
                    </div>
                </div>
                <div class="conf-meta">
                    <i class="fa fa-history" aria-hidden="true"></i> ${time_conf} 
                    <span class="text-flag aling-right" ${ifDisabled}>
                    <img src="/assets/images/flags/${pais.toLowerCase()}.svg">${pais}
                    </span>
                </div>
                <div class="conf-contenido">
                    ${confesion}
                </div>
                <form class="conf-footer" method="POST" action="../templates/funciones/reportar.php">
                    <input type="hidden" name="id_post" value='${id_conf}'>
                    <input type="submit" class="text-report aling-right" value="Reportar"/>
                </form>
            </div>
        </div>`);
            }
          );
        } else if (response.code === 404) {
          $no_more_results.html(`<p class="alert alert-warning a-red"><b class="red">!</b> ${response.message}</p>`);
        }
      });
  })();
};
on("DOMContentLoaded", window, () => {
  $confesiones_loader = $(`[data-result="confesiones-loader"]`);
  setTimeout(() => {
    getMoreData();
    $confesiones_loader.css({ display: "none" });
  }, 1000);
});
let desde = 0,
  total = 10;
on("scroll", window, () => {
  const { scrollHeight, clientHeight, scrollTop } = document.documentElement;
  clientHeight + scrollTop >= scrollHeight && getMoreData((desde += 10));
});
