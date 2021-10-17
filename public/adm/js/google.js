let autocomplete;
let address1Field;


function initAutocomplete() {
    address1Field = document.querySelector("#ship-address");
    autocomplete = new google.maps.places.Autocomplete(address1Field, {
        componentRestrictions: {
            country: ["br", "br"]
        },
        fields: ["address_components", "geometry"],
        types: ["address"],
    });
    address1Field.focus();
    autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
    const place = autocomplete.getPlace();

    for (const component of place.address_components) {
        const componentType = component.types[0];
        switch (componentType) {
            case "street_number":
                {
                    $("#numero").val(component.long_name);
                    break;
                }
            case "route":
                {
                    $("#rua").val(component.long_name);
                    break;
                }
            case "postal_code":
                {
                    $("#cep").val(component.long_name);
                    break;
                }
            case "administrative_area_level_2":
                {
                    $("#cidade").val(component.long_name);
                    break;
                }
            case "administrative_area_level_1":
                {
                    $("#estado").val(component.short_name);
                    break;
                }
            case "sublocality_level_1":
                $("#bairro").val(component.short_name);
                break;
        }
    }
}