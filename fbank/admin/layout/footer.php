</div>

<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © 2022 <a target="_blank" href="/"><?=$pageTitle ?></a>, All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class=""><?=$pageTitle ?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
    </div>
</div>
</div>
<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="./bootstrap/js/popper.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script src="./plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="./assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="./assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="./plugins/apex/apexcharts.min.js"></script>
<script src="./assets/js/dashboard/dash_1.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="./plugins/dropify/dropify.min.js"></script>
<script src="./plugins/blockui/jquery.blockUI.min.js"></script>
<!-- <script src="plugins/tagInput/tags-input.js"></script> -->
<script src="./assets/js/users/account-settings.js"></script>

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="./plugins/highlight/highlight.pack.js"></script>
<script src="./plugins/table/datatable/datatables.js"></script>
<script src="./plugins/select2/select2.min.js"></script>
<script src="./plugins/select2/custom-select2.js"></script>

<script src="./plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="./plugins/sweetalerts/custom-sweetalert.js"></script>
<script>
    var ss = $(".basic").select2({
        tags: true,
    });

</script>

<script>
$('input').attr('autocomplete', 'off');
</script>
<script>
    $('#default-ordering').DataTable( {
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        // "order": [[ 3, "desc" ]],
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered mb-5'); }
    } );
</script>

<script>

    $(".edit-crypto").click(function (e){
        e.preventDefault();
        $("#crypto_name").val($(this).data('name'));
        $("#wallet_address").val($(this).data('wallet-address'));
        $("#crypto_id").val($(this).data('id'));
        $(".show-modal").click();
    });

</script>

<script>

    function toast(msg,type){
        return swal({
            type: type,
            title: type,
            text: msg,
            padding: "2em"
        });
    }

    $(".delete-crypto-currency").on('click',function(e){
       e.preventDefault();
       let crypto_id = $(this).data('id');

        swal({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             type: 'warning',
             showCancelButton: true,
             confirmButtonText: 'Delete',
             padding: '2em'
         }).then(function(result) {
             if (result.value) {

                  $.ajax({
                        url : '<?= APP_URL.'admin/crypto-currrency.php'?>',
                        type : 'post',
                        dataType : 'json',
                        data : {
                            'delete_crypto_currency' : '',
                            'crypto_currency_id' : crypto_id
                        },
                        timeout : 45000,
                        success : function(data){
                            console.log('yey');

                            if(data.error == 1){
                                toast(data.msg,'success');
                            }else{
                                toast(data.msg,'error');
                            }

                            setTimeout(function(){
                                window.location.href='<?= APP_URL.'admin/crypto-currrency.php'?>';
                            },1000)
                        },
                        error : function(er){
                            // console.log(er.responseText);
                            toast('error network','error');
                        }
                    });

             }
         })

    });

</script>


<!-- END PAGE LEVEL SCRIPTS -->

</body>
</html>