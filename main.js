let block = false;
let page = 0;

window.onload = async function(){
    // cargar items
    loadItems();
}

window.addEventListener("scroll", async function(event) {
    const scrollHeight = this.scrollY;
    const viewportHeight = document.documentElement.clientHeight;
    const moreScroll = document.getElementById('more-conf').offsetTop;
    const currentScroll = scrollHeight + viewportHeight;

    if((currentScroll >= moreScroll) && block === false){ //cargar más contenido
        block = true;

        this.setTimeout(() =>{
            loadItems();

            block = false;
        }, 2000);
    }
});

async function loadItems(){
    const data = await requestData(page);
    const response = data[0];

    if(response.response === '200'){
        const items = data[1];
        page = data[2].page;

        renderItems(items);
    }else if(response.response === '400'){
        console.error('No hay mas confesiones para cargar.');
    }
}

function requestData(n){
    const url = 'core/api-conf.php?action=more&page=' + n;

    const response = this.fetch(url)
    .then(res => res.json())
    .then(data => data)

    return response;
}

function renderItems(data){
    let confes = document.querySelector('#confes');
    data.forEach(element => {
        confes.innerHTML += `
        <div class="conf-separador"></div>
    <div class="container-conf" id-confesion="${element.id_conf}">
        <div class="div-confesion-${element.genero}">
            <div class="conf-head-${element.genero}">
                <div class="conf-edad-h aling-left">
                    <i class="fa fa-${element.genero}" aria-hidden="true"></i><span> ${element.edad} </span>años
                </div>
            </div>
            <div class="conf-meta">
                <i class="fa fa-history" aria-hidden="true"></i> ${element.time_conf} <span class="text-flag aling-right" ${element.disable}><img src="/assets/images/flags/${element.pais}.svg"> ${element.pais}</span>
            </div>
            <div class="conf-contenido">
                ${element.confesion}
            </div>
            <form class="conf-footer" method="POST" action="../templates/funciones/reportar.php">
                <input type="hidden" name="id_post" value="${element.id_conf}">
                <input type="submit" class="text-report aling-right" value="Reportar"/>
            </form>
        </div>
    </div>`;
    });
}