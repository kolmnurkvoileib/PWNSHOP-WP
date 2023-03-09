<div id="repeater" style="
display: flex;
margin: 50px auto 50px auto;
margin-left: -10%;">
<?php
// Get the repeater field rows
$rows = get_field('repeater');

// Check if there are any rows
if($rows) {
    // Loop through each row
    foreach($rows as $row) {
        // Get the subfield values
        $image = $row['image'];
        $text = $row['text'];

        // Display the subfield values in a container element
        echo '<div style="display:inline-block; margin-right: -350px; margin-left:25%;">';
        echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
        echo '<p>' . $text . '</p>';
        echo '</div>';
    }
}

?>
</div>