function AddNewAsset() {
    event.preventDefault();

    var asset = {
        'CSRF': $("input[name=_token]").val(),
        'make': $('#makeTxtbox').val(),
        'model': $('#modelTxtbox').val(),
        'colour': $('#colourTxtbox').val(),
        'type': $('#assetTypeSelect').val(),
        'nickname': $('#nicknameTxtbox').val(),
        'registration': $('#registrationTxtbox').val(),
    };

    $.ajax({
        type: "POST",
        url: '/assets/add',
        headers: {
            'X-CSRF-TOKEN': asset.CSRF
        },
        data: asset,
        dataType: "JSON",
        complete: function(data) {
            const response = JSON.parse(data.responseText);

            switch (data.status) {
                case 200:
                    window.location.href = `/assets/${response.id}`;
                    break;

                case 422:
                    $.each(response.errors, function(error) {
                        $(`#${error}Txtbox`).addClass("is-invalid");

                        setTimeout(() => {
                            $(`#${error}Txtbox`).removeClass("is-invalid");
                        }, 2500);
                    });
                    break;

                default:
                    alert(data.responseText);
                    break;
            }
        }
    });
}

async function DeleteAsset(uid) {
    if (!uid) {
        return;
    }

    event.preventDefault();

    var asset = {
        'CSRF': $("input[name=_token]").val(),
        'uid': uid
    };

    $.ajax({
        type: "POST",
        url: '/assets/delete',
        headers: {
            'X-CSRF-TOKEN': asset.CSRF
        },
        data: asset,
        dataType: "JSON",
        complete: function(data) {
            const response = JSON.parse(data.responseText);

            switch (data.status) {
                case 200:
                    window.location.href = "/assets";
                    break;

                default:
                    alert(response.status);
                    break;
            }
        }
    });
}

function SaveAsset(uid) {
    event.preventDefault();

    var asset = {
        'CSRF': $("input[name=_token]").val(),
        'uid': uid,
        'make': $('#makeTxtbox').val(),
        'model': $('#modelTxtbox').val(),
        'colour': $('#colourTxtbox').val(),
        'type': $('#assetTypeSelect').val(),
        'nickname': $('#nicknameTxtbox').val(),
        'registration': $('#registrationTxtbox').val(),
    };

    $.ajax({
        type: "POST",
        url: '/assets/save',
        headers: {
            'X-CSRF-TOKEN': asset.CSRF
        },
        data: asset,
        dataType: "JSON",
        complete: function(data) {
            const response = JSON.parse(data.responseText);

            switch (data.status) {
                case 200:
                    alert('saved');
                    break;

                default:
                    alert(data.responseText);
                    break;
            }
        }
    });
}