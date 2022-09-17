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
                <div class="conf-head-${ifGenero} noselect">
                    <a class="confesion-id" href="post?id=${id_conf}">@${id_conf}</a>
                    <div class="conf-edad-h aling-left">
                        <i class="fa fa-${ifGenero}" aria-hidden="true"></i><span> <b>${edad}</b> </span>años
                    </div>
                </div>
                <div class="conf-meta noselect">
                    <i class="fa fa-history" aria-hidden="true"></i> ${time_conf} 
                    <span class="text-flag aling-right" ${ifDisabled}>
                    <img src="/assets/images/flags/${pais.toLowerCase()}.svg"> ${pais}
                    </span>
                </div>
                <div class="conf-contenido">
                    ${confesion}
                </div>
                <div class="conf-footer noselect">
                <form method="POST" action="">
                    <input type="hidden" name="id_post" value='${id_conf}'>
                    <button type="submit" class="btn-reportar aling-right" title="Reportar confesion"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                  </svg></button>
                </form>
                <a class="comentario aling-left" href="post?id=${id_conf}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text-fill" viewBox="0 0 16 16">
                <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/>
                </svg> Comentar</a>
                </div>
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
if (window.history.replaceState) { // verificamos disponibilidad
  window.history.replaceState(null, null, window.location.href);
}