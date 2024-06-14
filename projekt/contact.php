<?php
print '
		<h1>CONTACT</h1>
		<div id="contact">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2950.3021560691886!2d-83.21234808467932!3d42.31475367918991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x883b35011b1f5c9b%3A0x271dbe35824ca162!2sFord%20Motor%20Company%20World%20Headquarters!5e0!3m2!1sen!2shr!4v1639342050999!5m2!1sen!2shr" width="1500" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
			<form action="" id="contact_form" name="contact_form" method="POST"> 
				<label for="firstname">First Name *</label>
				<input type="text" id="firstname" name="firstname" placeholder="Your name.." required>

				<label for="lastname">Last Name *</label>
				<input type="text" id="lastname" name="lastname" placeholder="Your last name.." required>
				
				<label for="email">Your E-mail *</label>
				<input type="email" id="email" name="email" placeholder="Your e-mail.." required>

				<label for="country">Country</label>
				<select id="country" name="country">
				  <option value="">Please select</option>
				  <option value="CRO">Croatia</option>
				  <option value="US" selected>United States</option>
				  <option value="GER">Germany</option>
				  <option value="SER">Serbia</option>
                  <option value="IR">Ireland</option>
                  <option value="SUI">Switzerland</option>
                  <option value="BIH">Bosnia and Herzegovina</option>
                  <option value="MNE">Montenegro</option>
				</select>

				<label for="subject">Subject</label>
				<textarea id="subject" name="subject" placeholder="Write something..." style="height:100px"></textarea>

				<input type="submit" value="Submit">
			</form>
		</div>';
?>