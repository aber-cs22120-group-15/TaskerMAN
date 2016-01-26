
	</div>
	</div>


   <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <script type="text/javascript">



	    $(function(){           
	        if (!Modernizr.inputtypes.date) {
	        // If not native HTML5 support, fallback to jQuery datePicker
	            $('input[type=date]').datepicker({
	                // Consistent format with the HTML5 picker
	                    dateFormat : 'yy-mm-dd'
	                }
	            );
	        }
	    });

    </script>

	</body>
</html>
