<?php
include("includes\conn.php");
if (isset($_REQUEST["x"]) && strlen(trim($_REQUEST["x"])) > 0) {
    $song = $_REQUEST["x"];
    $s = explode(" ", $song);
    $sql = "SELECT * FROM tblbooks WHERE BookName LIKE '%" . $song . "%' ";
    for ($i = 0; $i < count($s); $i++) {
        $sql .= " OR BookName LIKE '%" . $s[$i] . "%'";
    }

    $stmt = $conn->query($sql);
    ?>
    <table width="80%" id="table" style="font-family:Lucida Handwriting;"> 


    <?php
    while ($row = mysqli_fetch_array($stmt)) {
        ?>
        <tr>
        <div class="gallery">
<div class="product" style="margin:20px;">
<?php $img = $row['ISBNNumber']?>
      <a href="admin/image/<?php echo $img?>.jpg" target="_blank">
        <img src="admin/image/<?php echo $img?>.jpg" alt="Description of your image">
    </a>
     <div style="margin-left:30%;" class="product-info">
   <?php $aid=$row['AuthorId'];

   $sql1 = "SELECT * FROM `tblauthors` WHERE `id`='$aid'";
   $result = mysqli_query($conn,$sql1);
   $arow = mysqli_fetch_array($result);
   $nbook = $row['books'];
   
   ?>
        <div class="book">Author: <b><?php echo $arow['AuthorName']?></b></div>
        <div class="book">Book Name: <b><?php echo $row['BookName']?></b></div>
         <?php if($nbook>=1){ ?>
            <div class="book">Shelf No: <b><?php echo $row['shelf']?></b></div>
        <div class="availability">In Stock</div>
        <?php }else{ 
            
           $bid = $row['id'];

            $sql2 = "SELECT * FROM `tblissuedbookdetails` WHERE `BookId`='$bid'";
            $result1 = mysqli_query($conn,$sql2);
            $rrow = mysqli_fetch_array($result1);
            
            
            ?>
            <div class="unavailability">Not Available </div>
            <div class="availability"><b>available On : <?php echo $rrow['ReturnDate'];?></b> </div>
            
            <?php }?>
 </div>
       </tr>
        <?php
    }
    ?>
</table>
<?php
}
?>