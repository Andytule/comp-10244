let map
let searchManager
let infoboxOptions
let infobox
let pushpinOptions
let pushpin
let center
let directionsManager
let address1 = 'Hamilton, Ontario'
let address2 = 'Burlington, Ontario'

function allClick() {
    loadMapScenario()
}

function elementaryClick() {
    loadMapScenario("Elementary School")
}

function middleClick() {
    loadMapScenario("Middle School")
}

function secondaryClick() {
    loadMapScenario("Secondary School")
}

function postClick() {
    loadMapScenario("Post Secondary")
}

function altClick() {
    loadMapScenario("Alternative Education")
}

function adultClick() {
    loadMapScenario("Adult Learning")
}

function sectionClick() {
    loadMapScenario("Section 23 Program")
}

let id = navigator.geolocation.getCurrentPosition(succesCallback, errorCallback)
let long
let lat
function succesCallback(position) {
    long = position.coords.longitude
    lat = position.coords.latitude
}

function errorCallback(error) {
    let errMsg
    switch (error.code) {
        case error.PERMISSION_DENIED:
            errMsg = 'User denied the request for geolocation'
            break
        case error.POSITION_UNAVAILABLE:
            errMsg = 'Location information is unavailable'
            break
        case error.TIMEOUT:
            errMsg = 'The request to get user location timed out'
            break
        case error.UNKNOWN_ERROR:
        default:
            errMsg = 'An unknown error occurred'
            break
    }
    $('#error').html(`Error: ${errMsg}`)
}

function loadMapScenario(filter, a = address1, b = address2) {
    let directionsManager
    //let current = new Microsoft.Maps.Location(long, lat)
    map = new Microsoft.Maps.Map(document.getElementById('map'))

    /*
    pushpin = new Microsoft.Maps.Pushpin(current, null)
    Microsoft.Maps.Events.addHandler(pushpin, 'click', function () {
        infobox.setOptions({
            location: current,
            title: "Center"
        })
    })
    map.entities.push(pushpin)
    */

    Microsoft.Maps.loadModule('Microsoft.Maps.Search', function () {
        searchManager = new Microsoft.Maps.Search.SearchManager(map)
    })

    infoboxOptions = {
        visible: false
    }

    infobox = new Microsoft.Maps.Infobox(map.getCenter(), infoboxOptions)
    infobox.setMap(map)

    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
        directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map)

        let start = new Microsoft.Maps.Directions.Waypoint({
            address: a
        })
        directionsManager.addWaypoint(start)

        let end = new Microsoft.Maps.Directions.Waypoint({
            address: b
        })
        directionsManager.addWaypoint(end)

        directionsManager.setRenderOptions({
            itineraryContainer: '#directions'
        })

        directionsManager.calculateDirections()

        let clearButton = document.getElementById('clear')
        clearButton.addEventListener('click', function () {
            directionsManager.clearAll()
        })
    })
    
    for (i = 0; i < education.length; i++) {
        let location
        if (filter) {
            directionsManager.clearAll()
            if (filter === education[i].CATEGORY) {
                location = new Microsoft.Maps.Location(education[i].LATITUDE, education[i].LONGITUDE)
                pushpinOptions = {}
                pushpin = new Microsoft.Maps.Pushpin(location, pushpinOptions)
                
                pushpin.metadata = {
                    title: education[i].NAME,
                    address: education[i].ADDRESS,
                    category: education[i].CATEGORY,
                    community: education[i].COMMUNITY
                }

                Microsoft.Maps.Events.addHandler(pushpin, 'click', pushpinClicked)

                map.entities.push(pushpin)
            }
        } else {
            location = new Microsoft.Maps.Location(education[i].LATITUDE, education[i].LONGITUDE)
            pushpinOptions = {}
            pushpin = new Microsoft.Maps.Pushpin(location, pushpinOptions)
            
            pushpin.metadata = {
                title: education[i].NAME,
                name: education[i].NAME,
                address: education[i].ADDRESS,
                category: education[i].CATEGORY,
                community: education[i].COMMUNITY,
                website: education[i].WEBSITE
            }

            Microsoft.Maps.Events.addHandler(pushpin, 'click', pushpinClicked)

            map.entities.push(pushpin)
        }
    }

    function pushpinClicked(pushpin) {
        let infoboxNewOptions = {
            location: pushpin.target.getLocation(),
            title: pushpin.target.metadata.title,
            description: "Name: " + pushpin.target.metadata.name +
                        "\nAddress: " + pushpin.target.metadata.address +
                        "\nCategory: " + pushpin.target.metadata.category + 
                        "\nCommunity: " + pushpin.target.metadata.community,
            actions: [
                {label: 'Directions', eventHandler : function() {
                    address1 = 'Hamilton, Ontario'
                    address2 = pushpin.target.metadata.address
                    loadMapScenario(null, address1, address2)
                }},
                {label: 'Website', eventHandler : function() {
                    window.open(pushpin.target.metadata.website)
                }}
            ],
            visible: true
        }
        infobox.setOptions(infoboxNewOptions)
    }
    
    
    
}

function add() {
    let name = document.getElementById("name").value
    let address = document.getElementById("address").value
    geocodeQuery(name, address)
}

function geocodeQuery(name, query) {
    let searchRequest = {
        where: query,
        callback: function (r) {
            if (r && r.results && r.results.length > 0) {
                pushpin = new Microsoft.Maps.Pushpin(r.results[0].location)
                Microsoft.Maps.Events.addHandler(pushpin, 'click', pushpinClicked)
                map.entities.push(pushpin)

                map.setView({
                    bounds: r.results[0].bestView,
                })
            } else {
                alert('Error')
            }
        },
        errorCallback: function (e) {
            alert('No results found')
        }
    }

    function pushpinClicked(pushpin) {
        infoboxNewOptions = {
            location: pushpin.target.getLocation(),
            title: name,
            visible: true
        }
        infobox.setOptions(infoboxNewOptions)
    }

    searchManager.geocode(searchRequest)
}

