<meta charset="utf-8">
<?php
  $link=mysqli_connect('localhost','root','root','phpdemo');
  mysqli_query($link,"set names utf8");

  $sql_total_records="select count(*) from user";
  $total_records_result=mysqli_query($link,$sql_total_records);
  $total_records=mysqli_fetch_row($total_records_result);

  $page_size=3;
  $total_pages=ceil($total_records[0]/$page_size);

  $current_page_number=isset($_GET['page_number'])?$_GET['page_number']:1;
  if($current_page_number<1){
    $current_page_number=1;
  }
  if($current_page_number>$total_pages){
    $current_page_number=$total_pages;
  }

  $begin_position=($current_page_number-1)*$page_size;
  $sql="select * from user limit $begin_position,$page_size";
  $result=mysqli_query($link,$sql);
  ?>
  <?php
    while (($row=mysqli_fetch_row($result))) {
      echo "<table>";
      echo "<tr>";
      echo "<td>".$row[0]."</td>";
      echo "<td>".$row[1]."</td>";
      echo "<td>".$row[2]."</td>";
      echo "</tr>";
      echo "</table>";
    }
?>
  <?php
    echo '<a href="paging.php?page_number=1">首页</a>&nbsp;&nbsp;';
    echo '<a href="paging.php?page_number='.($current_page_number-1).'">上一页</a>&nbsp;&nbsp;';
    echo '<a href="paging.php?page_number='.($current_page_number+1).'">下一页</a>&nbsp;&nbsp;';
    echo '<a href="paging.php?page_number='.($total_pages).'">尾页</a>&nbsp;&nbsp;';
    mysqli_free_result($result);
    mysqli_close($link);
  ?>