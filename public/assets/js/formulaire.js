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
    });

    // Soumission
    $("#inscription").submit(function (event) {
        event.preventDefault();
        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = $(this).serialize();
        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data,
            dataType: 'json',
        }).done(function (response) {
            if (response.status === true){
                CinetPay.setConfig({
                    apikey: '18714242495c8ba3f4cf6068.77597603',
                    site_id: 422630,
                    notify_url: 'http://sicre.scoutascci.org/cinetpay/notify'
                });
                CinetPay.setSignatureData({
                    amount: response.amount,
                    trans_id: response.id,
                    currency: 'CFA',
                    designation: 'Paiement de ' + parseInt(response.amount) + ' FCFA',
                });
                CinetPay.getSignature();
                CinetPay.on('signatureCreated', function (token) {});

                CinetPay.on('paymentPending', function (e) {});
                CinetPay.on('error', function (e) {});
                CinetPay.on('paymentSuccessfull', function (paymentInfo) {
                    if (typeof paymentInfo.lastTime != 'undefined') {
                        if (paymentInfo.cpm_result == '00') {
                            Swal.fire({
                                type: 'success',
                                title: 'Félicitation!',
                                text: 'votre inscription a ete effectuee avec succes. Voulez vous imprimez votre recu ?',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui',
                                cancelButtonText: 'Non, prochainement',
                            }).then((result) => {
                                if (result.value) {
                                    window.location = "http://sicre.scoutascci.org/inscription/"+response.slug;
                                } else {
                                    window.location.reload();
                                }
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Une erreur sur votre inscription.',
                                text: 'Veuillez contacter les administrateurs en leur transmettant le code ci-dessous.',
                                footer: response.id,
                            })
                        }
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Vous êtes déjà inscrit',
                    text:  "Si vous pensez que c'est une erreur, veuillez contacter donc le bureau national."
                })
            }
        })
    });
})