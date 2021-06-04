$().ready(function(){
    let districtId = $('#inscription_district').val()
    let url = $('#url').val()
    let spinner = $('#loader')

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
        spinner.show();

        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = $(this).serialize();

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data,
            dataType: 'json',
        }).done(function (response) {
            spinner.hide();
            if (response.status === true){
                console.log(response.apiKey)
                console.log(response.siteId)
                CinetPay.setConfig({
                    apikey: response.apiKey,
                    site_id: response.siteId,
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
                                    window.location = "http://sicre.scoutascci.org/inscription/"+paymentInfo.cpm_trans_id;
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