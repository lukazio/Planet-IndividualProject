<?php
session_start();
require 'modules/dbconnect.php';

$board_id = $_GET['id'];

if($_GET['category'] != 0){
    $category = $_GET['category'];
    $getNotesFilteredSql = "SELECT * FROM note WHERE board_id='$board_id' AND note_category='$category' ORDER BY note_modified DESC;";
    $getNotesFilteredResult = mysqli_query($conn,$getNotesFilteredSql);
    
    if(mysqli_num_rows($getNotesFilteredResult) > 0){
        foreach($getNotesFilteredResult as $row_filtered){
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 p-0">'
                    . '<div class="card m-2">';
                    if($row_filtered['note_category'] != 0){
                        $catRow = mysqli_fetch_assoc(mysqli_query($conn,"SELECT cat_name FROM category WHERE cat_id=".$row_filtered['note_category']));
                        $categoryName = $catRow['cat_name'];
                        echo '<h6 class="card-header text-secondary">'.$categoryName.'</h6>';
                    }
                        
                    echo '<div class="card-body">'
                            . '<a href="note_view.php?note_id='.$row_filtered['note_id'].'&id='.$board_id.'" class="card-text font-weight-bold stretched-link text-dark">'.$row_filtered['note_title'].'</a>'
                            . '<p class="card-text text-secondary mt-2">'
                                . '<span><i class="fa fa-fw fa-user" aria-hidden="true"></i> '.$row_filtered['note_creator'].'</span><br>'
                                . '<span><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> '.$row_filtered['note_editor'].'</span>'
                            . '</p>'
                        . '</div>'
                        . '<small class="card-footer text-muted py-2"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> '.$row_filtered['note_modified'].'</small>'
                    . '</div>'
                . '</div>';
        }
    }
    else{
        echo '<h3 class="text-center text-info">No notes in this category</h3>';
    }
}
else{
    $getNotesSql = "SELECT * FROM note WHERE board_id='$board_id' ORDER BY note_modified DESC;";
    $getNotesResult = mysqli_query($conn,$getNotesSql);
    
    if(mysqli_num_rows($getNotesResult) > 0){
        foreach($getNotesResult as $row){
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 p-0">'
                    . '<div class="card m-2">';
                    if($row['note_category'] != 0){
                        $catRow = mysqli_fetch_assoc(mysqli_query($conn,"SELECT cat_name FROM category WHERE cat_id=".$row['note_category']));
                        $categoryName = $catRow['cat_name'];
                        echo '<h6 class="card-header text-secondary">'.$categoryName.'</h6>';
                    }
                        
                    echo '<div class="card-body">'
                            . '<a href="note_view.php?note_id='.$row['note_id'].'&id='.$board_id.'" class="card-text font-weight-bold stretched-link text-dark">'.$row['note_title'].'</a>'
                            . '<p class="card-text text-secondary mt-2">'
                                . '<span><i class="fa fa-fw fa-user" aria-hidden="true"></i> '.$row['note_creator'].'</span><br>'
                                . '<span><i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> '.$row['note_editor'].'</span>'
                            . '</p>'
                        . '</div>'
                        . '<small class="card-footer text-muted py-2"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> '.$row['note_modified'].'</small>'
                    . '</div>'
                . '</div>';
        }
    }
    else{
        echo '<h3 class="text-center text-info">No notes found in this noteboard</h3>';
    }
}
?>