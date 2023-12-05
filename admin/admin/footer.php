</section>
</section>
<!--main content end-->
<!--footer start
      <footer class="site-footer">
          <div class="text-center">
              <?php echo date('Y') ?> &copy; 
              <a href="#" class="go-top">
                  <i class="icon-angle-up"></i>
              </a>
          </div>
      </footer>-->
<!--footer end-->
</section>
</div>
<!-- js placed at the end of the document so the pages load faster -->


<script src="js/bootstrap.min.js"></script>
<script src="assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="js/jquery.sparkline.js" type="text/javascript"></script>
<script src="assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.customSelect.min.js"></script>
<script src="js/respond.min.js"></script>
<script type="text/javascript" src="assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

<!-- Data picker -->
<script src="js/datapicker/bootstrap-datepicker.js"></script>

<!-- Chosen -->
<script src="js/chosen/chosen.jquery.js"></script>
<script src="js/jquery.blockUI.js"></script>
<!-- Toastr -->
<script src="js/toastr/toastr.min.js"></script>

<script src="js/iCheck/icheck.min.js"></script>

<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>


<!--script for this page-->
<script src="js/sparkline-chart.js"></script>
<script src="js/easy-pie-chart.js"></script>
<!-- <script src="js/count.js"></script> -->

<script>
    //owl carousel

    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            navigation: true,
            slideSpeed: 300,
            paginationSpeed: 400,
            singleItem: true,
            autoPlay: true

        });
    });

    //custom select box

    $(function() {
        $('select.styled').customSelect();
    });
</script>

<script>
    $(document).ready(function() {
        $('.colorpicker-default').colorpicker({
            format: 'hex'
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.chosen-select').chosen({
            width: "100%"
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<script>
    function checkButton() {
        if ($('#showbutton').iCheck('update')[0].checked == true) {
            $('#buttontextdiv').show();
        } else {
            $('#buttontextdiv').hide();
        }
    }
    $(document).ready(function() {
        $('#checkbuttondiv .iCheck-helper').click(function() {
            checkButton();
        });
    });

    $(document).ready(function() {
        $('#topsellingdiv .iCheck-helper').click(function() {
            if ($('#show_top').iCheck('update')[0].checked == true) {
                $('#maxtopdiv').show();
            } else {
                $('#maxtopdiv').hide();
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#data_5 .input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
    })
</script>

</body>

</html>