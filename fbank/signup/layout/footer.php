
<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="../bootstrap/js/popper.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/app.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="../assets/js/authentication/form-2.js"></script>
<script src="../plugins/highlight/highlight.pack.js"></script>
<script src="../assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY STYLES -->
<script src="../plugins/notification/snackbar/snackbar.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!--  BEGIN CUSTOM SCRIPTS FILE  -->
<script src="../assets/js/components/notification/custom-snackbar.js"></script>
<!--  END CUSTOM SCRIPTS FILE  -->

<!-- BEGIN THEME GLOBAL STYLE -->
<script src="../assets/js/scrollspyNav.js"></script>
<script src="../plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="../plugins/sweetalerts/custom-sweetalert.js"></script>
<script src="./formjs.js"></script>
<!-- END THEME GLOBAL STYLE -->
<script>
    $(document).ready(function(){
        $(".numpad").hide();
        $('.input').click(function(){
            $('.numpad').fadeToggle('fast');
        });

        $('.del').click(function(){
            $('.input').val($('.input').val().substring(0,$('.input').val().length - 1));
        });
        $('.faq').click(function(){
            alert("Enter Your OTP Sent to you ");
        })
        $('.shuffle').click(function(){
            $('.input').val($('.input').val() + $(this).text());
            $('.shuffle').shuffle();
        });
        (function($){

            $.fn.shuffle = function() {

                var allElems = this.get(),
                    getRandom = function(max) {
                        return Math.floor(Math.random() * max);
                    },
                    shuffled = $.map(allElems, function(){
                        var random = getRandom(allElems.length),
                            randEl = $(allElems[random]).clone(true)[0];
                        allElems.splice(random, 1);
                        return randEl;
                    });

                this.each(function(i){
                    $(this).replaceWith($(shuffled[i]));
                });

                return $(shuffled);

            };

        })(jQuery);

    });
</script>
<script>
    $(function() {
        $('#datepicker').keypress(function(event) {
            event.preventDefault();
            return false;
        });
    });


    function switchVisible() {
        if (document.getElementById('Div1')) {

            if (document.getElementById('Div1').style.display === 'none') {
                document.getElementById('Div1').style.display = 'block';
                document.getElementById('Div2').style.display = 'none';
                document.getElementById('nextShow').style.display = 'none';
            }
            else {
                document.getElementById('Div1').style.display = 'none';
                document.getElementById('Div2').style.display = 'block';
                document.getElementById('nextShow').style.display = 'block';
                document.getElementById('Button1').style.display='none';
            }
        }
    }


</script>
</body>
</html>