<?php
        if (!empty($_SESSION['success'])) {
        ?>
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['success']; ?>
            </div>
        <?php
            unset($_SESSION['success']);
        }
        ?>
        <?php
        if (!empty($_SESSION['errors'])) {
        ?>
            <div class="alert alert-danger">
            <p>There Were Following Error(s) Found...</p>
                <ul>
                    <?php
                    foreach ($_SESSION['errors'] as $err) {
                        print '<li>' . $err . '</li>';
                    }

                    ?>
                </ul>
            </div>
        <?php
            unset($_SESSION['errors']);
        }
        ?>