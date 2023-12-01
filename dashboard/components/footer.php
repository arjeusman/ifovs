			</div><!-- container -->
		</main><!-- content -->
	</div><!-- main -->

</div><!-- wrapper -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


<script type="text/javascript" src="script/script.js"></script>

</body>
</html>

<?php

if(isset($_SESSION['message'])):
	if($_SESSION['message']['page']!=basename($_SERVER['REQUEST_URI'])):
		unset($_SESSION['message']);
	endif;
endif;

?>