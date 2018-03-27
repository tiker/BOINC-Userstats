<script type = "text/javascript">
    Highcharts.setOptions({
        global: {
            useUTC: <?php echo $useUTCHighchartsOption; ?>
        },
        time: {
        /**
         * Use moment-timezone.js to return the timezone offset for individual
         * timestamps, used in the X axis labels and the tooltip header.
         */
        getTimezoneOffset: function (timestamp) {
            var zone = '<?php echo $timezone_name; ?>',
                timezoneOffset = -moment.tz(timestamp, zone).utcOffset();

            return timezoneOffset;
        }
    }
    });
</script>
