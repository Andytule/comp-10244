window.addEventListener("load", function() {
    $(document).ready(function() {

        let url = "index.php";
        const campSites = null;
        fetch(url, { credentials: "include"})
            .then(response => response.json())
            .then(function (camp) {
                campSites = camp
            })

        loadMapScenario()
    })
})

function loadMapScenario() {

    let map = new Microsoft.Maps.Map(document.getElementById("map"), {
        center: new Microsoft.Maps.Location(43.2557, -79.871)
    })

    let infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
        visible: false
    })

    infobox.setMap(map)

    for (let i = 0; i < campgrounds.length; i++) {
        let location = new Microsoft.Maps.Location(
            campgrounds[i].LATITUDE,
            campgrounds[i].LONGITUDE
        )

        let pushpin = new Microsoft.Maps.Pushpin(location, {
            title: campgrounds[i].NAME
        })

        pushpin.metadata = {
            title: campgrounds[i].NAME,
            description: campgrounds[i].ADDRESS
        }

        Microsoft.Maps.Events.addHandler(pushpin, "click", pushpinClicked)

        map.entities.push(pushpin)
    }

    function pushpinClicked(e) {
        infobox.setOptions({
            location: e.target.getLocation(),
            title: e.target.metadata.title,
            description: e.target.metadata.description,
            visible: true
        })
    }
}

