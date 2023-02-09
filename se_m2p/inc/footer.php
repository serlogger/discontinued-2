	<!-- Prevent enter from submitting the form -->
	<script>
		jQuery(function($) { // DOM ready

			$('form').on('keydown', function(ev) {
				if (ev.key === "Enter" && !$(ev.target).is('textarea')) {
				ev.preventDefault();
				}
			});

		});
	</script>