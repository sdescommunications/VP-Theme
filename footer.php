<!-- footers -->
<footer class="site-footer-container">

	<!-- main footer -->
	<div class="site-footer">
		<div class="container"> 
			<div class="row">
				<div class="col-lg-3 col-md-12">
					<h2>Upcoming Events</h2>
					<hr />
					<div class="row event">
						<div class="col-sm-3 date">
							<div class="month">April</div>
							<div class="day">7</div>
						</div>
						<div class="col-sm-8 description">
							<h3 class="event-title"><a href="http://events.ucf.edu/event/402863/mini-golf/">Mini Golf</a></h3>
							<h4 class="location"><a href="http://events.ucf.edu/event/402863/mini-golf/">Recreation and Wellness Center</a></h4>
						</div>
					</div>
					<div class="row event">
						<div class="col-sm-3 date">
							<div class="month">April</div>
							<div class="day">8</div>
						</div>
						<div class="col-sm-8 description">
							<h3 class="event-title"><a href="http://events.ucf.edu/event/409031/omgraduation/">OMGraduation!</a></h3>
							<h4 class="location"><a href="http://events.ucf.edu/event/409031/omgraduation/">Career Services &amp; Experiential Learning</a></h4>
						</div>
					</div>
					<p>
						<a class="btn btn-callout float-right" href="http://events.ucf.edu/?calendar_id=41&upcoming=upcoming">More Events</a>
					</p>
					<div class="clearfix"></div>
				</div>
				<div class="col-lg-4 col-md-12 offset-lg-1 offset-md-0">
					<h2>Quick Links</h2>
					<hr />
					<div class="row">
						<div class="col-sm-6 col-xs-6">
							<?= wp_nav_menu(array(
								'theme_location' => 'footer-menu-left',
								'menu_class' => 'list-unstyled',
							)) ?>
						</div>
						<div class="col-sm-6 col-xs-6">
							<?= wp_nav_menu(array(
								'theme_location' => 'footer-menu-right',
								'menu_class' => 'list-unstyled', 
							)) ?>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-12 offset-lg-1 offset-md-0">
					<h2 id="contact">Contact Us</h2>
					<hr />
					<h3 class="site-title"><?php bloginfo('name'); ?></h3>
					<p>
						<i class="fa fa-fw fa-phone"></i> <a href="tel:4078234625">407-823-4625</a><br />
						<i class="fa fa-fw fa-envelope"></i> <a href="mailto:sdes@ucf.edu">sdes@ucf.edu</a><br />								
						<i class="fa fa-fw fa-map-marker"></i> <a href="http://map.ucf.edu/?show=1">Millican Hall 282</a><br />
						<i class="fa fa-fw fa-facebook-square"></i> <a href="https://www.facebook.com/UCFStudentDevelopmentAndEnrollmentServices">Facebook</a><br />
						<i class="fa fa-fw fa-twitter"></i> <a href="https://twitter.com/ucf">Twitter</a>
					</p>
				</div>
			</div>
		</div>
	</div>

	<!-- sub footer -->
	<div class="site-sub-footer">
		<div class="container">
			<p class="text-center"><a class="footer-title" href="http://www.ucf.edu">University of Central Florida</a></p>	
			<br />				
			<div class="screen-only">
				<ul class="list-unstyled list-inline text-center">
					<li class="list-inline-item"><a href="https://www.ucf.edu/azindex/">A-Z Index</a></li>
					<li class="list-inline-item"><a href="https://www.ucf.edu/about-ucf/">About UCF</a></li>
					<li class="list-inline-item"><a href="https://www.ucf.edu/contact/">Contact UCF</a></li>
					<li class="list-inline-item"><a href="https://www.ucf.edu/internet-privacy-policy/">Internet Privacy Policy</a></li>
					<li class="list-inline-item"><a href="http://www.ucf.edu/online">Online Degrees</a></li>
					<li class="list-inline-item"><a href="http://www.ucf.edu/pegasus">Pegasus</a></li>
					<li class="list-inline-item"><a href="http://policies.ucf.edu" target="_blank" class="external">Policies</a></li>
					<li class="list-inline-item"><a href="http://regulations.ucf.edu/" target="_blank" class="external">Regulations</a></li>
					<li class="list-inline-item"><a href="http://today.ucf.edu" target="_blank" class="external">UCF News</a></li>
				</ul>			
			</div>
			<p class="ucf-footer-address text-center">
				4000 Central Florida Blvd. Orlando, Florida 32816 | <a href="tel:4078232000">407.823.2000</a>
				<br>
				© <a href="http://www.ucf.edu/">University of Central Florida</a>
			</p>
		</div>
	</div>
</footer>