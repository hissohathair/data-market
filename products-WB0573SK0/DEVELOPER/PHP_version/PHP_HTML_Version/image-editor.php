<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Image Cropping";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["forms"]["sub"]["imagecrop"]["active"] = true;
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
		//$breadcrumbs["New Crumb"] => "http://url.com"
		$breadcrumbs["Forms"] = "";
		include("inc/ribbon.php");
	?>
	
	<!-- MAIN CONTENT -->
	<div id="content">
		<!-- row -->
		<div class="row">

			<!-- col -->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h1 class="page-title txt-color-blueDark"><!-- PAGE HEADER --><i class="fa-fw fa fa-pencil-square-o"></i> Forms <span>>
					Image Editor </span></h1>
			</div>
			<!-- end col -->

		</div>
		<!-- end row -->

		<!--
		The ID "widget-grid" will start to initialize all widgets below
		You do not need to use widgets if you dont want to. Simply remove
		the <section></section> and you can use wells or panels instead
		-->

		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="alert alert-danger hidden-lg hidden-md hidden-sm">
						<b>Please note:</b>
						This plugin is non-responsive
					</div>

					<!-- Widget ID (each widget will need unique ID)-->

					<div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" role="widget" style="">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"

						-->
						<header role="heading">
							<span class="widget-icon"> <i class="fa fa-file-image-o txt-color-darken"></i> </span>
							<h2 class="hidden-xs hidden-sm">jcrop </h2>

							<ul class="nav nav-tabs pull-right in" id="myTab">
								
								<li class="active">
									<a data-toggle="tab" href="#s1"><i class="fa fa-crop text-success"></i> <span class="hidden-mobile hidden-tablet">API</span></a>
								</li>
								
								<li>
									<a data-toggle="tab" href="#s2"><i class="fa fa-crop text-primary"></i> <span class="hidden-mobile hidden-tablet">Default</span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#s3"><i class="fa fa-crop text-warning"></i> <span class="hidden-mobile hidden-tablet">Basic</span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#s4"><i class="fa fa-crop text-danger"></i> <span class="hidden-mobile hidden-tablet">Aspect Ratio</span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#s5"><i class="fa fa-crop txt-color-purple"></i> <span class="hidden-mobile hidden-tablet">Animations</span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#s6"><i class="fa fa-crop txt-color-pink"></i> <span class="hidden-mobile hidden-tablet">Styling</span></a>
								</li>

							</ul>

							<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
						</header>

						<!-- widget div-->
						<div role="content">
							<!-- widget edit box -->

							<div class="widget-body">
								<!-- content -->
								<div id="myTabContent" class="tab-content">

									<!-- new tab: API interface -->
									<div class="tab-pane fade active in" id="s1">

										<h4 class="margin-bottom-10">API Interface — real-time API example</h4>
										
										<div class="alert alert-info">
											<b>Experimental shader active.</b>
											Jcrop now includes a shading mode that facilitates building
											better transparent Jcrop instances. The experimental shader is less
											robust than Jcrop's default shading method and should only be
											used if you require this functionality.
											<br>
											View jcrop's documentation by going to: <a href="http://deepliquid.com/content/Jcrop.html" target="_blank">http://deepliquid.com/content/Jcrop.html</a>
										</div>
										
										<style type="text/css">
											.optdual {
												position: relative;
											}
											.optdual .offset {
												position: absolute;
												left: 18em;
											}
											.optlist label {
												width: 16em;
												display: block;
											}
											#dl_links {
												margin-top: .5em;
											}
								
										</style>
										
										<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-7.jpg" id="target-5" alt="[Jcrop Example]" class="pull-left" />
				
										<div class="pull-left padding-gutter padding-top-0 padding-bottom-0">
											
											<fieldset>

												<legend>
													Option Toggles
												</legend>										

												<span class="requiresjcrop">
													<button id="setSelect" class="btn btn-default btn-sm">
														setSelect
													</button>
													<button id="animateTo" class="btn btn-default btn-sm">
														animateTo
													</button>
													<button id="release" class="btn btn-default btn-sm">
														Release
													</button>
													<button id="disable" class="btn btn-default btn-sm">
														Disable
													</button> 
												</span>
												<button id="enable" class="btn btn-default btn-sm" style="display:none;">
													Re-Enable
												</button>
												<button id="unhook" class="btn btn-default btn-sm">
													Destroy!
												</button>
												<button id="rehook" class="btn btn-default btn-sm" style="display:none;">
													Attach Jcrop
												</button>
											</fieldset>
											
											<fieldset class="optdual requiresjcrop">
												<legend>
													Option Toggles
												</legend>
												<div class="optlist offset">
													<label class="checkbox  margin-top-0">
													  <input type="checkbox" class="checkbox style-0" id="ar_lock">
													  <span>Aspect ratio</span>
													</label>
													
													<label class="checkbox">
													  <input type="checkbox" class="checkbox style-0" id="size_lock">
													  <span>minSize/maxSize setting</span>
													</label>
												</div>
												<div class="optlist">
													<label class="checkbox  margin-top-0">
													  <input type="checkbox" class="checkbox style-0" id="can_click">
													  <span>Allow new selections</span>
													</label>
													
													<label class="checkbox">
													  <input type="checkbox" class="checkbox style-0" id="can_move">
													  <span>Selection can be moved</span>
													</label>
													
													<label class="checkbox">
													  <input type="checkbox" class="checkbox style-0" id="can_size">
													  <span>Resizable selection</span>
													</label>

												</div>
											</fieldset>
				
											<fieldset class="requiresjcrop">
												<legend>
													Change Image
												</legend>
												<div class="btn-group">
													<button class="btn btn-default" id="img2">
														Lego
													</button>
													<button class="btn btn-default active" id="img1">
														Breakdance
													</button>
													<button class="btn btn-default" id="img3">
														Dragon Fly
													</button>
												</div>
											</fieldset>
										
										</div>	

									</div>
									<!-- end s1 tab pane -->

									<!-- new tab: Default -->
									<div class="tab-pane fade" id="s2">

										<h4 class="margin-bottom-10">Default Behaviour</h4>

										<div class="alert alert-info">
											<b>This example demonstrates the default behavior of Jcrop.</b>
											<br />
											Since no event handlers have been attached it only performs
											the cropping behavior.
										</div>

										<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-11.jpg" id="target" alt="[Jcrop Example]" />

									</div>
									<!-- end s1 tab pane -->

									<!-- new tab: Basic handler -->
									<div class="tab-pane fade" id="s3">

										<h4 class="margin-bottom-10">Basic Handler — basic form integration</h4>

										<div class="alert alert-info">
											<b>An example with a basic event handler.</b> Here we've tied
											several form values together with a simple event handler invocation.
											The result is that the form values are updated in real-time as
											the selection is changed using Jcrop's <em>onChange</em> handler.
										</div>

										<!-- This is the image we're attaching Jcrop to -->
										<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-10.jpg" id="target-2" alt="[Jcrop Example]" />

										<!-- This is the form that our event handler fills -->
										<form id="coords"
										class="coords margin-top-10"
										onsubmit="return false;"
										action="http://example.com/post.php">

											<div class="inline-labels">
												<label>X1
													<input type="text" size="4" id="x1" name="x1" />
												</label>
												<label>Y1
													<input type="text" size="4" id="y1" name="y1" />
												</label>
												<label>X2
													<input type="text" size="4" id="x2" name="x2" />
												</label>
												<label>Y2
													<input type="text" size="4" id="y2" name="y2" />
												</label>
												<label>W
													<input type="text" size="4" id="w" name="w" />
												</label>
												<label>H
													<input type="text" size="4" id="h" name="h" />
												</label>
											</div>
										</form>

									</div>
									<!-- end s2 tab pane -->

									<!-- new tab: Aspect ratio -->
									<div class="tab-pane fade" id="s4">

										<style type="text/css">
											/* Apply these styles only when #preview-pane has
											 been placed within the Jcrop widget */
											.jcrop-holder #preview-pane {
												display: block;
												position: absolute;
												z-index: 200;
												right: -280px;
												padding: 3px;
												border: 1px rgba(0,0,0,.4) solid;
												background-color: white;
												-webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.1);
												-moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.1);
												box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.1);
											}

											/* The Javascript code will set the aspect ratio of the crop
											 area based on the size of the thumbnail preview,
											 specified here */
											#preview-pane .preview-container {
												width: 250px;
												height: 170px;
												overflow: hidden;
											}

										</style>

										<h4 class="margin-bottom-10">Aspect Ratio w/ Preview Pane — nice visual example</h4>

										<div class="alert alert-info">
											<b>An example implementing a preview pane.</b>
											Obviously the most visual demo, the preview pane is accomplished
											entirely outside of Jcrop with a simple jQuery-flavored callback.
											This type of interface could be useful for creating a thumbnail
											or avatar. The onChange event handler is used to update the
											view in the preview pane.
										</div>

										<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-9.jpg" id="target-3" alt="[Jcrop Example]" />

										<div id="preview-pane">
											<div class="preview-container">
												<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-9.jpg" class="jcrop-preview" id="target-3" alt="Preview" />
											</div>
										</div>

									</div>
									<!-- end s3 tab pane -->

									<!-- new tab: animation/transitions -->
									<div class="tab-pane fade" id="s5">

										<h4 class="margin-bottom-10">Animation/Transitions — animation/fading demo</h4>

										<div class="alert alert-info">
											<b>Experimental shader active.</b>
											Jcrop now includes a shading mode that facilitates building
											better transparent Jcrop instances. The experimental shader is less
											robust than Jcrop's default shading method and should only be
											used if you require this functionality.
										</div>

										<div class="row">

											<div class="col-sm-12 col-md-12 col-lg-12">

												<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-7.jpg" id="target-4" alt="Jcrop Image" class="pull-left" />

					
												<div id="interface" class="pull-left padding-gutter padding-top-0 padding-bottom-0">
													
													<label class="checkbox">
													  <input type="checkbox" class="checkbox style-0" id="fadetog">
													  <span>Enable fading (bgFade: true)</span>
													</label>
													<label class="checkbox">
													  <input type="checkbox" class="checkbox style-0" id="shadetog">
													  <span>Use experimental shader (shade: true)</span>
													</label>
												
												</div>
											</div>

										</div>

									</div>
									<!-- end s4 tab pane -->

									<!-- new tab: Styling -->
									<div class="tab-pane fade padding-10 no-padding-bottom" id="s6">

										<h4 class="margin-bottom-10">Styling Example — style Jcrop dynamically with CSS</h4>

										<img src="<?php echo ASSETS_URL; ?>/img/superbox/superbox-full-16.jpg" id="target-6" alt="[Jcrop Example]" />
				
										<div class="pull-left pull-left padding-gutter padding-top-0 padding-bottom-0">
											<fieldset>
												<legend>
													Manipulate classes
												</legend>
												<div class="btn-group" id="buttonbar">
													<button class="btn btn-default active" data-setclass="jcrop-light" id="radio1">
														jcrop-light
													</button>
													<button class="btn btn-default" data-setclass="jcrop-dark" id="radio2">
														jcrop-dark
													</button>
													<button class="btn btn-default" data-setclass="jcrop-normal" id="radio3">
														normal
													</button>
												</div>
											</fieldset>
										</div>

									</div>
									<!-- end s6 tab pane -->

								</div>

								<!-- end content -->
							</div>

						</div>
						<!-- end widget div -->
					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->

			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->
	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<!-- PAGE FOOTER -->
<?php
	// include page footer
	include("inc/footer.php");
?>
<!-- END PAGE FOOTER -->

<?php 
	//include required scripts
	include("inc/scripts.php"); 
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="<?php echo ASSETS_URL; ?>/js/plugin/YOURJS.js"></script>-->


<script src="<?php echo ASSETS_URL; ?>/js/plugin/jcrop/jquery.Jcrop.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/plugin/jcrop/jquery.color.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
		//console.log("load and ready");


		// api_handler
		
		var api_handler = function() {

			// The variable jcrop_api will hold a reference to the
			// Jcrop API once Jcrop is instantiated.
			var jcrop_api;


			// The function is pretty simple
			var initJcrop = function(){
				// Hide any interface elements that require Jcrop
				// (This is for the local user interface portion.)
				$('.requiresjcrop').hide();

				// Invoke Jcrop in typical fashion
				$('#target-5').Jcrop({
					onRelease : releaseCheck
				}, function() {

					jcrop_api = this;
					jcrop_api.animateTo([100, 100, 400, 300]);

					// Setup and dipslay the interface for "enabled"
					$('#can_click,#can_move,#can_size').attr('checked', 'checked');
					$('#ar_lock,#size_lock,#bg_swap').attr('checked', false);
					$('.requiresjcrop').show();

				});

			};

			// In this example, since Jcrop may be attached or detached
			// at the whim of the user, I've wrapped the call into a function	
			initJcrop();

			// Use the API to find cropping dimensions
			// Then generate a random selection
			// This function is used by setSelect and animateTo buttons
			// Mainly for demonstration purposes
			function getRandom() {
				var dim = jcrop_api.getBounds();
				return [Math.round(Math.random() * dim[0]), Math.round(Math.random() * dim[1]), Math.round(Math.random() * dim[0]), Math.round(Math.random() * dim[1])];
			};

			// This function is bound to the onRelease handler...
			// In certain circumstances (such as if you set minSize
			// and aspectRatio together), you can inadvertently lose
			// the selection. This callback re-enables creating selections
			// in such a case. Although the need to do this is based on a
			// buggy behavior, it's recommended that you in some way trap
			// the onRelease callback if you use allowSelect: false
			function releaseCheck() {
				jcrop_api.setOptions({
					allowSelect : true
				});
				$('#can_click').attr('checked', false);
			};

			// Attach interface buttons
			// This may appear to be a lot of code but it's simple stuff
			$('#setSelect').click(function(e) {
				// Sets a random selection
				jcrop_api.setSelect(getRandom());
			});
			$('#animateTo').click(function(e) {
				// Animates to a random selection
				jcrop_api.animateTo(getRandom());
			});
			$('#release').click(function(e) {
				// Release method clears the selection
				jcrop_api.release();
			});
			$('#disable').click(function(e) {
				// Disable Jcrop instance
				jcrop_api.disable();
				// Update the interface to reflect disabled state
				$('#enable').show();
				$('.requiresjcrop').hide();
			});
			$('#enable').click(function(e) {
				// Re-enable Jcrop instance
				jcrop_api.enable();
				// Update the interface to reflect enabled state
				$('#enable').hide();
				$('.requiresjcrop').show();
			});
			$('#rehook').click(function(e) {
				// This button is visible when Jcrop has been destroyed
				// It performs the re-attachment and updates the UI
				$('#rehook,#enable').hide();
				initJcrop();
				$('#unhook,.requiresjcrop').show();
				return false;
			});
			$('#unhook').click(function(e) {
				// Destroy Jcrop widget, restore original state
				jcrop_api.destroy();
				// Update the interface to reflect un-attached state
				$('#unhook,#enable,.requiresjcrop').hide();
				$('#rehook').show();
				return false;
			});

			// Hook up the three image-swapping buttons
			$('#img1').click(function(e) {
				$(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');

				jcrop_api.setImage('img/superbox/superbox-full-7.jpg');
				jcrop_api.setOptions({
					bgOpacity : .6
				});
				return false;
			});
			$('#img2').click(function(e) {
				$(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');

				jcrop_api.setImage('img/superbox/superbox-full-24.jpg');
				jcrop_api.setOptions({
					bgOpacity : .6
				});
				return false;
			});
			$('#img3').click(function(e) {
				$(this).addClass('active').closest('.btn-group').find('button.active').not(this).removeClass('active');

				jcrop_api.setImage('img/superbox/superbox-full-20.jpg', function() {
					this.setOptions({
						bgOpacity : 1,
						outerImage : 'img/superbox/superbox-full-20-bw.jpg'
					});
					this.animateTo(getRandom());
				});
				return false;
			});

			// The checkboxes simply set options based on it's checked value
			// Options are changed by passing a new options object

			// Also, to prevent strange behavior, they are initially checked
			// This matches the default initial state of Jcrop

			$('#can_click').change(function(e) {
				jcrop_api.setOptions({
					allowSelect : !!this.checked
				});
				jcrop_api.focus();
			});
			$('#can_move').change(function(e) {
				jcrop_api.setOptions({
					allowMove : !!this.checked
				});
				jcrop_api.focus();
			});
			$('#can_size').change(function(e) {
				jcrop_api.setOptions({
					allowResize : !!this.checked
				});
				jcrop_api.focus();
			});
			$('#ar_lock').change(function(e) {
				jcrop_api.setOptions(this.checked ? {
					aspectRatio : 4 / 3
				} : {
					aspectRatio : 0
				});
				jcrop_api.focus();
			});
			$('#size_lock').change(function(e) {
				jcrop_api.setOptions(this.checked ? {
					minSize : [80, 80],
					maxSize : [350, 350]
				} : {
					minSize : [0, 0],
					maxSize : [0, 0]
				});
				jcrop_api.focus();
			});

		}
		
		// end api_handler

		// default
		
		var default_handler = function(){
			$('#target').Jcrop();
		}

		// basic handler

		var basic_handler = function() {

			var jcrop_api;

			$('#target-2').Jcrop({
				onChange : showCoords,
				onSelect : showCoords,
				onRelease : clearCoords
			}, function() {
				jcrop_api = this;
			});

			$('#coords').on('change', 'input', function(e) {
				var x1 = $('#x1').val(), x2 = $('#x2').val(), y1 = $('#y1').val(), y2 = $('#y2').val();
				jcrop_api.setSelect([x1, y1, x2, y2]);
			});

			// Simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showCoords(c) {
				$('#x1').val(c.x);
				$('#y1').val(c.y);
				$('#x2').val(c.x2);
				$('#y2').val(c.y2);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function clearCoords() {
				$('#coords input').val('');
			};

		};

		// end basic_handler

		// aspect ratio

		var aspect_ratio = function() {

			// Create variables (in this scope) to hold the API and image size
			var jcrop_api, boundx, boundy,

			// Grab some information about the preview pane
			$preview = $('#preview-pane'), $pcnt = $('#preview-pane .preview-container'), $pimg = $('#preview-pane .preview-container img'), xsize = $pcnt.width(), ysize = $pcnt.height();

			console.log('init', [xsize, ysize]);
			$('#target-3').Jcrop({
				onChange : updatePreview,
				onSelect : updatePreview,
				aspectRatio : xsize / ysize
			}, function() {
				// Use the API to get the real image size
				var bounds = this.getBounds();
				boundx = bounds[0];
				boundy = bounds[1];
				// Store the API in the jcrop_api variable
				jcrop_api = this;

				// Move the preview into the jcrop container for css positioning
				$preview.appendTo(jcrop_api.ui.holder);
			});

			function updatePreview(c) {
				if (parseInt(c.w) > 0) {
					var rx = xsize / c.w;
					var ry = ysize / c.h;

					$pimg.css({
						width : Math.round(rx * boundx) + 'px',
						height : Math.round(ry * boundy) + 'px',
						marginLeft : '-' + Math.round(rx * c.x) + 'px',
						marginTop : '-' + Math.round(ry * c.y) + 'px'
					});
				}
			};

		}
		// end aspect_ratio

		// animation_handler

		var animation_handler = function() {

			var jcrop_api;

			$('#target-4').Jcrop({
				bgFade : true,
				bgOpacity : .2,
				setSelect : [60, 70, 540, 330]
			}, function() {
				jcrop_api = this;
			});

			$('#fadetog').change(function() {
				jcrop_api.setOptions({
					bgFade : this.checked
				});
			}).attr('checked', 'checked');

			$('#shadetog').change(function() {
				if (this.checked)
					$('#shadetxt').slideDown();
				else
					$('#shadetxt').slideUp();
				jcrop_api.setOptions({
					shade : this.checked
				});
			}).attr('checked', false);

			// Define page sections
			var sections = {
				bgc_buttons : 'Change bgColor',
				bgo_buttons : 'Change bgOpacity',
				anim_buttons : 'Animate Selection'
			};
			// Define animation buttons
			var ac = {
				anim1 : [217, 122, 382, 284],
				anim2 : [20, 20, 580, 380],
				anim3 : [24, 24, 176, 376],
				anim4 : [347, 165, 550, 355],
				anim5 : [136, 55, 472, 183]
			};
			// Define bgOpacity buttons
			var bgo = {
				Low : .2,
				Mid : .5,
				High : .8,
				Full : 1
			};
			// Define bgColor buttons
			var bgc = {
				R : '#900',
				B : '#4BB6F0',
				Y : '#F0B207',
				G : '#46B81C',
				W : 'white',
				K : 'black'
			};
			// Create fieldset targets for buttons
			for (i in sections)insertSection(i, sections[i]);

			function create_btn(c) {
				var $o = $('<button />').addClass('btn btn-default btn-small');
				if (c)
					$o.append(c);
				return $o;
			}

			var a_count = 1;
			// Create animation buttons
			for (i in ac) {
				$('#anim_buttons .btn-group').append(create_btn(a_count++).click(animHandler(ac[i])), ' ');
			}

			$('#anim_buttons .btn-group').append(create_btn('Bye!').click(function(e) {
				$(e.target).addClass('active');
				jcrop_api.animateTo([300, 200, 300, 200], function() {
					this.release();
					$(e.target).closest('.btn-group').find('.active').removeClass('active');
				});
				return false;
			}));

			// Create bgOpacity buttons
			for (i in bgo) {
				$('#bgo_buttons .btn-group').append(create_btn(i).click(setoptHandler('bgOpacity', bgo[i])), ' ');
			}
			// Create bgColor buttons
			for (i in bgc) {
				$('#bgc_buttons .btn-group').append(create_btn(i).css({
					background : bgc[i],
					color : ((i == 'K') || (i == 'R')) ? 'white' : 'black'
				}).click(setoptHandler('bgColor', bgc[i])), ' ');
			}
			// Function to insert named sections into interface
			function insertSection(k, v) {
				$('#interface').prepend($('<fieldset></fieldset>').attr('id', k).append($('<legend></legend>').append(v), '<div class="btn-toolbar"><div class="btn-group"></div></div>'));
			};
			// Handler for option-setting buttons
			function setoptHandler(k, v) {
				return function(e) {
					$(e.target).closest('.btn-group').find('.active').removeClass('active');
					$(e.target).addClass('active');
					var opt = { };
					opt[k] = v;
					jcrop_api.setOptions(opt);
					return false;
				};
			};
			// Handler for animation buttons
			function animHandler(v) {
				return function(e) {
					$(e.target).addClass('active');
					jcrop_api.animateTo(v, function() {
						$(e.target).closest('.btn-group').find('.active').removeClass('active');
					});
					return false;
				};
			};

			$('#bgo_buttons .btn:first,#bgc_buttons .btn:last').addClass('active');
			$('#interface').show();

		}
		// end animation_handler
		
		// styling_handler
		
		var styling_handler = function () {
			
			var api;

			$('#target-6').Jcrop({
				// start off with jcrop-light class
				bgOpacity : 0.5,
				bgColor : 'white',
				addClass : 'jcrop-light'
			}, function() {
				api = this;
				api.setSelect([130, 65, 130 + 350, 65 + 285]);
				api.setOptions({
					bgFade : true
				});
				api.ui.selection.addClass('jcrop-selection');
			});

			$('#buttonbar').on('click', 'button', function(e) {
				var $t = $(this), $g = $t.closest('.btn-group');
				$g.find('button.active').removeClass('active');
				$t.addClass('active');
				$g.find('[data-setclass]').each(function() {
					var $th = $(this), c = $th.data('setclass'), a = $th.hasClass('active');
					if (a) {
						api.ui.holder.addClass(c);
						switch(c) {

							case 'jcrop-light':
								api.setOptions({
									bgColor : 'white',
									bgOpacity : 0.5
								});
								break;

							case 'jcrop-dark':
								api.setOptions({
									bgColor : 'black',
									bgOpacity : 0.4
								});
								break;

							case 'jcrop-normal':
								api.setOptions({
									bgColor : $.Jcrop.defaults.bgColor,
									bgOpacity : $.Jcrop.defaults.bgOpacity
								});
								break;
						}
					} else
						api.ui.holder.removeClass(c);
				});
			});
			
		}
		
		// end styling_handler
		
		//run functions
		
		api_handler();
		default_handler();
		basic_handler();
		aspect_ratio();
		animation_handler();
		styling_handler();
	});

</script>

<?php 
	//include footer
	include("inc/google-analytics.php"); 
?>