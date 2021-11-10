<?php

global $current_user;

// echo '<pre>';
// print_r($current_user);
// echo '</pre>';

$name = $current_user['name'];

$name_f = wad_get_name_part('first',$name);
$name_l = wad_get_name_part('last',$name);
$email = $current_user['email'];



?>
<?php wad_header(); ?>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	<div class="d-flex flex-column-fluid">
		<div class="container">
			<h2 class="mb-6">Support</h2>
			<p>Having technical difficulties? Please leave a message below and we'll touch base soon!</p>
			<p>For all assignment-related questions, please Message The Team in your order and use the "Question" tag</p>
			<form
			   method="post"
			   action="https://app.wordagents.com/contact/og-helpdesk"
			   id="spp-og-helpdesk">
			   <div class="form-group-lg" data-field="1">
				  <label for="name_f">Name</label>
				  <div class="form-row">
					 <div class="form-group col-sm-6">
						<input
						   type="text"
						   class="form-control"
						   name="name_f"
						   id="name_f"
						   value="<?php echo $name_f; ?>"
						   autocomplete="given-name"
						   required>
						<div class="help-block">First name</div>
					 </div>
					 <div class="form-group col-sm-6">
						<input
						   type="text"
						   class="form-control"
						   name="name_l"
						   value="<?php echo $name_l; ?>"
						   autocomplete="family-name"
						   required>
						<div class="help-block">Last name</div>
					 </div>
				  </div>
			   </div>
			   <div class="form-group form-group-lg" data-field="2">
				  <label for="email">Email</label>
				  <input
					 type="email"
					 name="email"
					 id="email"
					 class="form-control"
					 placeholder=""
					 value="<?php echo $email; ?>"
					 autocomplete="email"
					 required>
				  <?php /* <div class="help-block">
					 Already have an account? <a href="https://app.wordagents.com/login">Sign in here</a>.            
				  </div> */ ?>
			   </div>
			   <div class="form-group form-group-lg" data-field="3">
				  <label
					 for="field_3"
					 class=""
					 >Subject</label>
				  <input
					 type="text"
					 class="form-control data-input"
					 name="field_3"
					 id="field_3"
					 placeholder=""
					 required        value="">
			   </div>
			   <div class="form-group form-group-lg" data-field="4">
				  <label
					 for="field_4"
					 class=""
					 >Message</label>
				  <textarea
					 name="field_4"
					 id="field_4"
					 class="form-control data-input"
					 placeholder=""
					 required    ></textarea>
			   </div>
			   <div class="form-group form-group-lg" data-field="5">
					<label for="field_5" class="optional">File upload</label>

					<input
						type="file"
						id="field_5"
						name="field_5"
						class="form-control"
						>
				</div>
			   <div class="form-group">
				  <button
					 type="submit"
					 class="btn btn-primary btn-block"
					 >Send message</button>
			   </div>
			</form>
		</div>
	</div>
</div>

<script>
    // Script handles ajax form submission
    // On error show alert
    // On success redirect user to "thank you" page
    const form = document.querySelector("#spp-og-helpdesk");

    form.addEventListener("submit", e => {
        e.preventDefault();

        const xhr = new XMLHttpRequest();
        xhr.responseType = "json";

        xhr.addEventListener("load", () => {
            if (xhr.status < 400) {
                // Successful request, redirect to thanks page
                window.location = xhr.response.url;
            } else {
                // Show error message
                alert(xhr.response.message);
            }
        });

        // General request error
        xhr.addEventListener("error", () => {
            alert("Network error, please try again later.");
        });

        // Ajax param returns JSON responses
        xhr.open("POST", form.action + '?_ajax');
        xhr.send(new FormData(form));
    });
</script>

<?php wad_footer(); ?>