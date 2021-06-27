var map = document.querySelector('#map')
var paths = map.querySelectorAll('.map__image a')
var links = map.querySelectorAll('.map__list a')

// Polyfill du foreach
if(NodeList.prototype.forEach === undefined){
    NodeList.prototype.forEach = function(callback){
        [].forEach.call(this, callback)
    }
}

var activeArea = function (id){
    map.querySelectorAll('.is-active').forEach(function(item){
        item.classList.remove('is-active')
    })

    if (id !== undefined){
        document.querySelector('#region-'+id).classList.add('is-active');
        document.querySelector('#'+id).classList.add('is-active');
    }
}



paths.forEach(function(path){
    path.addEventListener('mouseover', function(e){
        var id = this.id
        activeArea(id)
        information(id)
    })
})

links.forEach(function(link){
    link.addEventListener('mouseenter', function(){
        var id = this.id.replace('region-','')
        activeArea(id)
        information(id)
    })
})

map.addEventListener('mouseleave', function(){
    activeArea();
})