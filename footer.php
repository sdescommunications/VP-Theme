<!-- footers -->
<footer class="site-footer-container">

	<!-- main footer -->
	<div class="site-footer">
		<div class="container"> 
			<div class="row">
				<div class="col-lg-3 col-md-12">
					<h2>Upcoming Events</h2>
					<hr />
					<?= do_shortcode( '[calendar cal_id="41" action="upcoming" count="2"]' ) ?>				
					
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
					<h3 class="site-title"><?= str_replace(' | ', '<br />', get_bloginfo('name')) ?></h3>
					<p>
						<?= do_shortcode( '[contactblock contactname="main" f="true"]' ) ?>
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
					<li class="list-inline-item"><a href="http://policies.ucf.edu" target="_blank" >Policies</a></li>
					<li class="list-inline-item"><a href="http://regulations.ucf.edu/" target="_blank" >Regulations</a></li>
					<li class="list-inline-item"><a href="http://today.ucf.edu" target="_blank" >UCF News</a></li>
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