flag = true;
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
}}});