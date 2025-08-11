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
  
</style>
    <link href="<?php echo site_url(); ?>/wp-content/plugins/Shahkar/admin/ui/assets/css/dash.css" rel="stylesheet">

<?php

if(isset($_GET['i'])){
  global $wpdb;
  $sec = new secure();
  $i = $sec->input($_GET['i']);
        $tableName = 'Shahkar_notifications';
        $sql = $wpdb->prepare("DELETE FROM $tableName WHERE vn_id = %d", $i);
  		if($wpdb->query($sql)){

  ?>
<div class="notice notice-success is-dismissible">
        <p><?php _e( ' اعلان با آی دی '.$i.' با موفقیت حذف شد ', 'sample-text-domain' ); ?></p>
    </div>
<?php
        }else{ ?>
<div class="notice notice-warning is-dismissible">
        <p><?php _e( ' خطا در حذف اعلان ', 'sample-text-domain' ); ?></p>
    </div>        <?php }
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
            'title'    => ' عنوان ',
            'text'   => 'متن',
            'date'   => 'تاریخ',
            'delete'   => 'حذف',
        ];
    }

    public function prepare_items() {
        global $wpdb;

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $total_items = $wpdb->get_var("SELECT COUNT(	vn_id) FROM Shahkar_notifications");

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page'    => $per_page,
        ]);

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = [$columns, $hidden, $sortable];

        $offset = ($current_page - 1) * $per_page;
        $this->items = $wpdb->get_results("SELECT * FROM Shahkar_notifications LIMIT $per_page OFFSET $offset", ARRAY_A);
    }

    public function column_default($item, $column_name) {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    public function column_row($item) {
        return $item['vn_id'];
    }
public function column_title($item) {
        return $item['vn_title'];
    }
    public function column_text($item) {
        echo $item['vn_text'];
    }

    public function column_date($item) {
        return ShahkarJdate\jdate("Y/m/d",$item['vn_date']);
    }
  public function column_delete($item) {
    $id = $item['vn_id'];
        return '<a class="delete-btn" href="?page=users_notification_list&i='.$id.'"> حذف </a>';
    }


  public function column_link($item) {
    $link = $item['vt_id'];
        return "<a href='/wp-admin/admin.php?page=reply_chat&i=$link'>مشاهده</a>";
    }
}

  
  $wp_list_table = new Custom_WP_List_Table();
    $wp_list_table->prepare_items();

    echo '<div class="wrap">';
    echo '<h1> لیست اعلانات </h1>';
	echo '<a class="shahkar-btn" href="?page=users_notification"> ارسال اعلان جدید </a>';
    $wp_list_table->display();
    echo '</div>';
?>
