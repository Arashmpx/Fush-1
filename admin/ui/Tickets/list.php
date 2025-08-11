    <link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css" rel="stylesheet">
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
</style>
<?php
 $Sec = new secure();
$Sec->DDOS('admin');
function GetDepartemanName($Did){
  global $wpdb;
  $sql_one = "SELECT vd_title FROM Shahkar_support_departments WHERE vd_id='$Did'";

$results_one = $wpdb->query($sql_one);
$data_one = $wpdb->get_results($sql_one, OBJECT);
  return $data_one[0]->vd_title;
}
function GetPriorityName($pid){
  if($pid=="1"){
    return " کم ";
  }elseif($pid=="2"){
    return " زیاد ";
  }elseif($pid=="3"){
    return " بحرانی ";
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
            'title'    => 'عنوان درخواست',
            'user'   => 'کاربر',
            'date'   => 'تاریخ',
            'dep'   => 'دپارتمان',
            'priority'   => 'اولویت',
            'status'   => 'وضعیت',
            'link'   => 'مشاهده',
        ];
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(vt_id) FROM Shahkar_tickets");

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ]);

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        $offset = ($current_page - 1) * $per_page;

      
      $admin_id = get_current_user_id();  

$query = "
    SELECT DISTINCT t.*
    FROM Shahkar_tickets t
    JOIN Shahkar_departments_admin_access da ON t.vt_department = da.da_DepID
    WHERE da.da_AdminID = %d
    order by vt_id desc
    LIMIT %d OFFSET %d
";



$this->items = $wpdb->get_results($wpdb->prepare($query, $admin_id, $per_page, $offset), ARRAY_A);
    }

    public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    public function column_row($item) {
        return $item['vt_id'];
    }
public function column_title($item) {
        return $item['vt_title'];
    }
    public function column_user($item) {
        $user = new user();

        return $user->Shahkar_getDisplayName($item['vt_uid']);
    }

    public function column_date($item) {
        return ShahkarJdate\jdate("Y/m/d",$item['vt_date']);
    }
  public function column_dep($item) {
        return GetDepartemanName($item['vt_department']);
    }
  public function column_priority($item) {
        return GetPriorityName($item['vt_Priority']);
    }
  public function column_status($item) {
        if($item['vt_status']=="0"){ ?>
      	<div class="shahkar-chat-box-side-item-value pending-status"> در انتظار پاسخ </div>
        <?php }elseif($item['vt_status']=="1"){ ?>
      	<div class="shahkar-chat-box-side-item-value success-status">پاسخ داده شده</div>
        <?php }elseif($item['vt_status']=="2"){ ?>
      	<div class="shahkar-chat-box-side-item-value disable-status"> بسته شده  </div>
        <?php }elseif($item['vt_status']=="3"){ ?>
      	<div class="shahkar-chat-box-side-item-value pending-status"> درحال بررسی </div>
        <?php }
    }
  public function column_link($item) {
    $site_url = site_url();
    $link = $item['vt_id'];
        return "<a href='$site_url/wp-admin/admin.php?page=reply_chat&i=$link' class='shahkar-btn'>مشاهده</a>";
    }
}

  
  $wp_list_table = new Custom_WP_List_Table();
    $wp_list_table->prepare_items();

    echo '<div class="wrap">';
    echo '<h1>لیست درخواست های پشتیبانی</h1>';
    $wp_list_table->display();
    echo '</div>';

?>