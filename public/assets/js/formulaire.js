$().ready(function(){
    let districtId = $('#inscription_district').val()
    let url = $('#url').val()

    // Gestion des groupes
    $('#inscription_district').on('change', function () {
        let districtId = $(this).val()
        $.get(url, {value: districtId})
            .done(function (data) {
                if (data){
                    $('#inscription_groupe').empty();
                    $('#inscription_groupe').append("<option value=''>--</option>")
                    for (let i = 0; i < data.length; i++){
                        const item = data[i]
                        $('#inscription_groupe').append(
                            "<option value="+item.id+">"+item.paroisse+"</option>"
                        )
                    }
                }
            })
    })
})