<?php
$Sec = new secure();
$Sec->DDOS('admin');
?>
    <link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/styles/toastify.min.css">

<style>
        body ,#tinymce{
            font-family: 'regular' !important;
            font-size: 18px;
        }
  .panel-form .input {
    width: 100%;
    margin-bottom: 10px;
}

.panel-form .half-input {
    width: 49%;
    margin-bottom: 10px;
}

.panel-form label span {
    font-family: 'extra-bold', serif;
    font-size: .8em;
    margin: 10px 0;
    display: inline-block;
}

.panel-form input[type="text"], .panel-form input[type="file"], .panel-form select, .panel-form textarea, .panel-form input[type="submit"], .panel-form button {
    width: calc(100% );
    resize: none;
    border: 1px solid #ddd;
    background: white;
    padding: 10px;
    border-radius: 5px;
    font-family: 'regular', serif;
    font-size: .8em;
}

.panel-form .inputs {
    display: flex;
    justify-content: space-between;
}

.panel-form input[type="submit"], .panel-form button {
    width: auto;
    margin-top: 20px;
    cursor: pointer;
    background: var(--primary-color);
    border: none;
    color: white;
    font-family: 'extra-bold', serif;
    padding: 10px;
}

</style>
<div class="wrap">
  <div class="panel-form">
    <div class="input">
      <label>
      	<span>عنوان اعلان</span>
  		<input id="shahkar_notification_title" placeholder="عنوان اعلان خود را وارد نمایید ..." type="text" class="regular-text">
      </label>    	
    </div>
    <div class="inputs">
      	<div class="half-input">
        	<label>
              <span> ارسال به استان ها </span>
              <select id="SendByStates">
                <option value="ALL" /selected>همه استان ها</option>
                <?php
                global $wpdb;
                $sql_states = "SELECT * FROM Shahkar_states";

                $results_states = $wpdb->query($sql_states);
                $data_states = $wpdb->get_results($sql_states, OBJECT);
				 foreach ($data_states as $states) { ?>
                                <option value="<?php echo $states->woo_code; ?>"> <?php echo $states->name; ?> </option>
                            <?php
                           
                }
                ?>
             
              </select>
            </label>  	
      	</div>
      	<div class="half-input">
        	<label>
              <span>بر اساس جنسیت</span>
              <select id="SendByGender">
                <option value="ALL"> همه جنسیت ها </option>
                <option value="1">برای آقایان</option>
                <option value="2"> برای خانم ها </option>
              </select>
            </label>  	
      	</div>
    </div>
  </div>
  <?php 
  wp_editor('', 'shahkar_notification_text');
  ?>
  <div class="panel-form">
  <div class="input">
      <label>
        <button id="send">ارسال اعلان</button>
      </label>    	
    </div>
  </div>
</div>
<script src="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/user_page/dashboard/assets/js/toastify-js.js"></script>
<script>
      function showmsg(tx, rgb) {
            Toastify({
                text: tx,
                duration: 5000,
                destination: "#",
                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                backgroundColor: rgb,
                stopOnFocus: true, // Prevents dismissing of toast on hover
                onClick: function() {} // Callback after click
            }).showToast();
        }
    
    $("#send").click(function() {
              var color = 'linear-gradient(to right, #95a5a6, #7f8c8d)';
        showmsg('در حال ارسال اعلان', color);
            //Send request Shahkar SUpport

            var title = $('#shahkar_notification_title').val();
            var text = tinymce.get('shahkar_notification_text').getContent();
      		var SendByStates = $("#SendByStates").val();
      		var SendByGender = $("#SendByGender").val();
            const httpURL = '<?php echo site_url(); ?>';

            $.ajax({
                type: 'POST',
                url: httpURL + '/wp-content/plugins/Shahkar/includes/AJAX/Administrator/Notifications/Send.php',
                data: {
                    title: title,
                    text: text,
                  	SendByStates: SendByStates,
                  	SendByGender: SendByGender
                },
                success: function(data) {
                    var res = JSON.parse(data);
          	var response = res.response;
          	var status = res.status;
          	var title = res.title;
          	var color = res.color;
                    
                    showmsg('' + response + '', '' + color + '');
                    
                    if (res.redirect == 1) {
                        setTimeout(function() {
                             location.reload(); 
                        }, 1500)

                    }
                }
            });
        });
</script>