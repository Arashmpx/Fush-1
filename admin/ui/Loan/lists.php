<?php

$Sec = new secure();
$Sec->DDOS('admin');
?>
<style>
  *{
        font-family: 'bold', serif !important;
    }
  .shahkar-btn {
    width: auto;
    margin-top: 10px!important;
    cursor: pointer;
    display: inline-block;
    background: #3bc0b1;
    border: none;
    border-radius:5px;
    color: white;
    text-decoration: none;
    font-family: 'extra-bold', serif;
    padding: 10px;
}
  .shahkar-btn:hover{
   	color:white; 
  }
  
  .shahkar-btn:active ,.shahkar-btn:focus{
   	color:white !important; 
  }
  .delete-btn{
  background: red;
  color: white;
  padding: 2px 8px;
  border-radius: 5px;
  border: none; 
  }
  
  .delete-btn:hover{
   	color:white; 
  }
  
  .wrap h1{
    	font-family:'bold',serif
  }	
  .shahkar-btn {
        width: fit-content;
        display: flex;
        align-items: center;
        margin-top: 10px !important;
        cursor: pointer;
        background: #3bc0b1;
        border: none;
        border-radius: 5px;
        color: white;
        text-decoration: none;
        font-family: 'extra-bold', serif;
        padding: 5px;
        font-size:12px;
    }

    .shahkar-icon {
        width: 15px;
        display: flex;
        height: 15px;
        fill: white;
        margin-left: 7px;
    }
  .alternate, .striped > tbody > :nth-child(2n+1), ul.striped > :nth-child(2n+1){
   	background:#eee; 
  }
  
</style>
    <link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css?v=1.6" rel="stylesheet">

<?php

if(isset($_GET['i'])){
  global $wpdb;
  $sec = new secure();
  $i = $sec->input($_GET['i']);
  $type = $sec->input($_GET['type']);
  $Loan = new Loan();
  
    $queryinfo = $wpdb->prepare("SELECT * FROM shahkar_request_loan WHERE vrl_id = $i");
$results = $wpdb->query($queryinfo);
$data = $wpdb->get_results($queryinfo, OBJECT);
  
  
  if($type=="accept"){
    
    if($data[0]->vrl_status=="0" || $data[0]->vrl_status=="3" || $data[0]->vrl_status=="2"){
    $Loan->AcceptByAdmin($i);
    ?>
<div class="notice notice-success is-dismissible">
        <p><?php _e( ' درخواست وام با شناسه '.$i.' با موفقیت تایید شد ', 'sample-text-domain' ); ?></p>
    </div>
<?php
    }
    
  }elseif($type=="Noaccept"){
    $Loan->NoAcceptByAdmin($i);
    ?>
<div class="notice notice-warning is-dismissible">
        <p><?php _e( ' درخواست وام با شناسه '.$i.' رد شد ', 'sample-text-domain' ); ?></p>
    </div> 
<?php
    
  }elseif($type=="BackAmount"){
  if($data[0]->vrl_status=="1"){
  if($Loan->BackAmount($i)){
 ?>
<div class="notice notice-warning is-dismissible">
        <p><?php _e( ' مبلغ وام با موفقیت از اعتبار کیف پول کاربر کسر شد ', 'sample-text-domain' ); ?></p>
    </div> 
<?php     
  }else{
   
     ?>
<div class="notice notice-warning is-dismissible">
        <p><?php _e( ' خطایی در انجام عملیات رخ داده است ! ', 'sample-text-domain' ); ?></p>
    </div> 
<?php 
    
  }
    
    
  }else{
 ?>
<div class="notice notice-warning is-dismissible">
        <p><?php _e( ' این وام در وضعیت تایید شده نمی باشد به همین دلیل امکان باز پس گیری وام در این وضعیت امکان پذیر نمی باشد ( هنوز مبلغی به حساب کاربر واریز نشده است ) ', 'sample-text-domain' ); ?></p>
    </div> 
<?php 
}
  
}

    
}


class Custom_WP_List_Table extends WP_List_Table {
    public function __construct() {
        parent::__construct([
            'singular' => 'custom_item',
            'plural'   => 'custom_items',
            'ajax'     => false,
        ]);
    }

    public function get_columns() {
        return [
            'row'             => '#',
            'user'    => ' کاربر ',
            'amount'   => 'مبلغ',
            'date'   => 'تاریخ',
            'percent'   => 'درصد سود',
            'backamount'   => ' بازپرداخت ',
            'admin'   => 'ادمین تایید کننده',
            'function'   => 'عملیات',
            'status'   => 'وضعیت',
        ];
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(vrl_id) FROM shahkar_request_loan");

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ]);

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        $offset = ($current_page - 1) * $per_page;
        $this->items = $wpdb->get_results("SELECT * FROM shahkar_request_loan LIMIT $per_page OFFSET $offset", ARRAY_A);
    }

    public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    public function column_row($item) {
        return $item['vrl_id'];
    }
public function column_user($item) {
  		$user = new user();
        return $user->Shahkar_getDisplayName($item['vrl_uid']);
    }
    public function column_amount($item) {
        echo number_format($item['vrl_amount']) . " تومان  ";
    }

    public function column_date($item) {
        return ShahkarJdate\jdate("Y/m/d ساعت : H:i",$item['vrl_date']);
    }
  public function column_percent($item) {
        echo $item['vrl_percent'] . " درصد ";
    }
  public function column_backamount($item) {
        echo number_format($item['vrl_amount'] * ($item['vrl_percent'] / 100)) . ' تومان ';

    }
  public function column_admin($item) {
        $user = new user();
        return $user->Shahkar_getDisplayName($item['vrl_admin']);
    }
  public function column_function($item) {
    $vrl_i = $item['vrl_id'];
    if($item['vrl_status']=="1"){
        echo  '<a href="admin.php?page=shahkar_RequestLoan&type=BackAmount&i=' . $vrl_i . '" style="display:flex;align-items:center;color:white" class="shahkar-btn edit-btn" >
    <div>
        <svg class="shahkar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
          <path d="M37.5,8H20.926c-1.955,0-3.807,0.749-5.213,2.108l-9.909,9.578C4.624,20.827,3.975,22.358,3.975,24s0.649,3.173,1.829,4.313l9.909,9.578C17.119,39.251,18.971,40,20.926,40H37.5c3.584,0,6.5-2.916,6.5-6.5v-19C44,10.916,41.084,8,37.5,8z M35.561,29.439c0.586,0.586,0.586,1.535,0,2.121C35.268,31.854,34.884,32,34.5,32s-0.768-0.146-1.061-0.439L28,26.121l-5.439,5.439C22.268,31.854,21.884,32,21.5,32s-0.768-0.146-1.061-0.439c-0.586-0.586-0.586-1.535,0-2.121L25.879,24l-5.439-5.439c-0.586-0.586-0.586-1.535,0-2.121s1.535-0.586,2.121,0L28,21.879l5.439-5.439c0.586-0.586,1.535-0.586,2.121,0s0.586,1.535,0,2.121L30.121,24L35.561,29.439z" fill="#FFFFFF" />
        </svg>
    </div>
    <div> پس گرفتن وام  </div>
</a>';
   }else{
      if($item['vrl_status']!=="4"){
        echo  '<a href="admin.php?page=shahkar_RequestLoan&type=accept&i=' . $vrl_i . '" style="display:flex;align-items:center;" class="shahkar-btn" >
    <div>
        <svg class="shahkar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
          <path d="M24,4C12.972,4,4,12.972,4,24s8.972,20,20,20s20-8.972,20-20S35.028,4,24,4z M32.561,20.561l-10,10C22.268,30.854,21.884,31,21.5,31s-0.768-0.146-1.061-0.439l-5-5c-0.586-0.586-0.586-1.535,0-2.121s1.535-0.586,2.121,0l3.939,3.939l8.939-8.939c0.586-0.586,1.535-0.586,2.121,0S33.146,19.975,32.561,20.561z" fill="#FFFFFF" />
        </svg>
    </div>
    <div> تایید  </div>
</a> | 
<a href="admin.php?page=shahkar_RequestLoan&type=Noaccept&i=' . $vrl_i . '" style="display:flex;align-items:center;" class="shahkar-btn delete-btn">
    <div>
        <svg class="shahkar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
          <path d="M24,4C12.954,4,4,12.954,4,24c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20C44,12.954,35.046,4,24,4z M31.561,29.439c0.586,0.586,0.586,1.535,0,2.121C31.268,31.854,30.884,32,30.5,32s-0.768-0.146-1.061-0.439L24,26.121l-5.439,5.439C18.268,31.854,17.884,32,17.5,32s-0.768-0.146-1.061-0.439c-0.586-0.586-0.586-1.535,0-2.121L21.879,24l-5.439-5.439c-0.586-0.586-0.586-1.535,0-2.121s1.535-0.586,2.121,0L24,21.879l5.439-5.439c0.586-0.586,1.535-0.586,2.121,0s0.586,1.535,0,2.121L26.121,24L31.561,29.439z" fill="#FFFFFF" />
        </svg>
    </div>
    <div> رد  </div>
</a>
';
      }
    }
    
  }
  public function column_status($item) {
    if($item['vrl_status']=="0"){
        echo  '<div class="shahkar-chat-box-side-item-value pending-status"> در انتظار تایید </div>';
    }elseif($item['vrl_status']=="1"){
     echo  '<div class="shahkar-chat-box-side-item-value success-status"> تایید شده </div>';
    }elseif($item['vrl_status']=="2"){
     echo  '<div class="shahkar-chat-box-side-item-value cancel-status"> رد شده </div>';
    }elseif($item['vrl_status']=="3"){
     echo  '<div class="shahkar-chat-box-side-item-value cancel-status"> پس گرفته شده </div>';
    }elseif($item['vrl_status']=="4"){
     echo  '<div class="shahkar-chat-box-side-item-value success-status"> پرداخت شده </div>';
    }
    
    }


  public function column_link($item) {
    $link = $item['vt_id'];
        return "<a href='/wp-admin/admin.php?page=reply_chat&i=$link'>مشاهده</a>";
    }
}

  
  $wp_list_table = new Custom_WP_List_Table();
    $wp_list_table->prepare_items();

    echo '<div class="wrap">';
    echo '<h1> درخواست های وام ( اعتبار خرید ) کاربران  </h1>';
    $wp_list_table->display();
    echo '</div>';
?>
