</div>

</div>
<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © 2022 <?php echo $pageTitle ?>, All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class=""><?php echo $pageTitle ?> </p>
    </div>
    
    
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='<?= $page['livechat'] ?>';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</div>
</div>
<!--  END CONTENT AREA  -->


</div>
</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<!--<script src="../assets/js/libs/jquery-3.1.1.min.js"></script>-->
<script src="../bootstrap/js/popper.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="../plugins/file-upload/file-upload-with-preview.min.js"></script>
<script src="../assets/js/app.js"></script>
<script src="../assets/js/users/account-settings.js"></script>
<script src="../plugins/dropify/dropify.min.js"></script>
<script src="../plugins/blockui/jquery.blockUI.min.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="../assets/js/custom.js"></script>
<script>
    var data = <?= @json_encode($data); ?>;
    console.log(data);
    function crypto_type(id){
        for(var i =0; i < data.length; i++){
            if(id == data[i].id){
                $("#wallet_address").val(data[i].wallet_address);
            }
        }
    }
    var firstUpload = new FileUploadWithPreview('myFirstImage')
</script>
<!-- END GLOBAL MANDATORY SCRIPTS -->


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../plugins/table/datatable/datatables.js"></script>
<script>
    $('#default-ordering').DataTable( {
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        //"order": [[ 3, "desc" ]],
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7,
        drawCallback: function () { $('.dataTables_paginate > .pagination').addClass(' pagination-style-13 pagination-bordered'); }
    } );
</script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
    }
</script>

<script>
    // Get the Toast button
    var toastButton = document.getElementById("toast-btn");
    // Get the Toast element
    var toastElement = document.getElementsByClassName("toast")[0];

    toastButton.onclick = function() {
        $('.toast').toast('show');
    }


</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="../plugins/apex/apexcharts.min.js"></script>
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/dashboard/dash_1.js"></script>
<script src="../plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="../plugins/sweetalerts/custom-sweetalert.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->



<script src="../plugins/notification/snackbar/snackbar.min.js"></script>
<script src="../assets/js/clipboard/clipboard.min.js"></script>
<script src="../assets/js/forms/custom-clipboard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>
<script src="../assets/js/card/card.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="../assets/js/components/notification/custom-snackbar.js"></script>

</body>
</html>