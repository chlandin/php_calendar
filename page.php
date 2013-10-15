<!doctype html>
<html lang="en">
    <head>
        <title>PHP Calendar</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="js/zebra_datepicker.js"></script>
    </head>
    <body>
        <h1>PHP Calendar</h1>
        <div class="wrapper">
            <div class="event-form">
                <form action="" method="post">
                    <div>
                        <label for="description">Description</label><br />
                        <textarea id="description" name="description" rows="3" required ><?php echo $description; ?></textarea>
                    </div>
                    <div>
                        <label for="date">Date <span>(format 2013-04-09)</span></label><br />
                        <input type="text" class="datepicker" name="date_from" id="date_from" value="<?php echo $date_from; ?>" required /> to 
                        <input type="text" class="datepicker" name="date_to" id="date_to" value="<?php echo $date_to; ?>" required /><br />
                        <label for="date">Time <span>(format 10:00)</span></label><br />
                        <input type="text" name="time_from" id="time_from" value="<?php echo $time_from; ?>" required /> to 
                        <input type="text" name="time_to" id="time_to" value="<?php echo $time_to; ?>" required />
                    </div>
                    <div>
                        <label for="title">Title</label><br />
                        <input type="text" name="title" id="title" value="<?php echo $title; ?>" required /><br />
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="action" value="Save">
                    </div>
                </form>
            </div>
            <div class="event-listings">
            <?php if (isset($events)) : ?>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Starts</th>
                        <th>Ends</th>
                        <th></th>
                    </tr>
                    <?php foreach ($events as $event) : ?>
                        <tr>
                            <td>
                                <?php echo $event['title']; ?>
                            </td>
                            <td>
                                <?php $init = new FormatDateOutput($event['date_from'], $event['time_from']); ?>
                            </td>
                            <td>
                                <?php $init = new FormatDateOutput($event['date_to'], $event['time_to']); ?>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                                    <input type="submit" name="action" value="Edit">
                                    <input type="submit" name="action" onclick="return confirm('Händelsen kommer att raderas!');" value="Delete">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $event['description']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <p>There are no events to display.</p>
            <?php endif; ?>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('input.datepicker').Zebra_DatePicker();
            });
        </script>
    </body>
</html>
