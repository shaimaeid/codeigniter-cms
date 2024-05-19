<?php $this->load->model('template_parts_model'); ?> 

<!-- Our-Clients- start -->
    <div class="sixteen columns">
      <h4 class="subtitle">Our Clients</h4>

          <ul id="our-clients" class="our-clients">
            <?php echo template_parts_model::get_clients(); ?>
          </ul>

    </div>
	<!-- Our-Clients- end -->
    <div class="vertical-space2"></div>
  </section>
  <!-- end- -->