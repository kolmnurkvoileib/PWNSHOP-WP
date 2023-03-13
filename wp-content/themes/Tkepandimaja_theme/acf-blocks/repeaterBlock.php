<div class="repeaterblock">
    
  <div class="repeaterblock_item">
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
          echo '<div class="repeaterblock_item__wrapper">';
          echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
          echo '<p>' . $text . '</p>';
          echo '</div>';
        }
      }
    ?>
  </div>

</div>