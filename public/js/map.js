let map;

async function initMap() {
    //Position de l'entreprise
    const position = { lat: 48.0, lng: -1.0278 };

    // Request needed libraries.
    //@ts-ignore
    //Position de l'entreprise
    const { Map } = await google.maps.importLibrary("maps");

    //Création de la carte
    map = new Map(document.getElementById("map"), {
        zoom: 7,
        center: position,
        mapId: "MAP_ID",
        
    });

    // Le marqueur
    const marker = new google.maps.Marker({
        position: position,
        map,
        title: "J'ai un bouc et y'm'sert",
    });

    //Premier cercle de 80km
    const firstRadius = new google.maps.Circle({
        strokeColor: "#f38038",
        strokeOpacity: 0.4,
        strokeWeight: 2,
        fillColor: "#f38038",
        fillOpacity: 0.25,
        map,
        center: position,
        radius: 80000,
    });

    //Deuxième cercle de 40km
    const secondRadius = new google.maps.Circle({
        strokeColor: "#70972d",
        strokeOpacity: 0.4,
        strokeWeight: 2,
        fillColor: "#8EBC40",
        fillOpacity: 0.4,
        map,
        center: position,
        radius: 40000,
    });
    
    const contentString =
    'En rouge : jusqu\'à 80KM pour les nouveau clients<br>En vert : idéalement jusqu\'à 40KM';

    const infowindow = new google.maps.InfoWindow({
        content: contentString,
        ariaLabel: "J'ai un bouc et y'm'sert",
    });
    
    marker.addListener("click", () => {
        infowindow.open({
            anchor: marker,
            map,
        });
    });
}

initMap();
