<?php
  $link=mysqli_connect('localhost','root','root','phpdemo');
  mysqli_query($link,"set names utf8");

//获得中的记录数
  $sql_total_records="select count(*) from user";
  $total_records_result=mysqli_query($link,$sql_total_records);
  $total_records=mysqli_fetch_row($total_records_result);

//获得总页数,一般来说页面大小是固定的,所以这里暂且定为一页4个数据
  $page_size=6;
  $total_pages=ceil($total_records[0]/$page_size);

//通过GET方式获得客户端访问的页码
  $current_page_number=isset($_GET['page_number'])?$_GET['page_number']:1;
  if($current_page_number<1){
    $current_page_number=1;
  }
  if($current_page_number>$total_pages){
    $current_page_number=$total_pages;
  }

//获取到了要访问的页面以及页面大小,下面开始分页
  $begin_position=($current_page_number-1)*$page_size;
  $sql="select * from user limit $begin_position,$page_size";
  $result=mysqli_query($link,$sql);
  ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
</head>

<body>
<div id="m-right">
	<div>
	<form method="post" action="userAction.php?action=delete">
		<table>
			<caption class="m-cap">用户管理</caption>
			<tr>
				<th></th>
				<th>id号</th>
				<th>用户名</th>
				<th>密码</th>
				<th>操作</th>
			</tr>
			
			<?php 
			while ($row=mysqli_fetch_assoc($result)) { ?>
				<tr>
					<td><input type='checkbox' name='item[]' id='item[]' value='<?php echo $row[id] ?>'/></td>
					<td><?php echo $row[id] ?></td>
					<td><?php echo $row[username] ?></td>
					<td><?php echo $row[password] ?></td>
					<td>
						<input type='button' name='update' value='修改' style='cursor: pointer;height: 22px;width: 40px;' onclick="window.location.href='userupdate.php?id=<?php echo $row[id] ?>'"/>
					</td>
				</tr>
			<?php } ?>
			<tr>
				<td class="insert" colspan="5">
					<input type="button" name="register" value="插入" class="btn" onclick="window.location.href='userinsert.php'">
					<input type='submit' name='delete' value='删除' class="btn" style='cursor: pointer;'/>
				</td>
			</tr>
			<tr>
				<td colspan="5" style="text-align: center;">
					<?php
					    echo '<a href="1.php?page_number=1">首页</a>&nbsp;&nbsp;';
					    echo '<a href="1.php?page_number='.($current_page_number-1).'">上一页</a>&nbsp;&nbsp;';
					    echo "$current_page_number/$total_pages";
					    echo '<a href="1.php?page_number='.($current_page_number+1).'">下一页</a>&nbsp;&nbsp;';
					    echo '<a href="1.php?page_number='.($total_pages).'">尾页</a>&nbsp;&nbsp;';
					    mysqli_free_result($result);
					    mysqli_close($link);
					  ?>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>
</body>
</html>