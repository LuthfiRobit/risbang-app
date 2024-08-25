<script>
    // Cycle through each textarea and add placeholder with individual word limits
    $("textarea[word-limit=true]").each(function() {
        $(this).attr("placeholder", "Entri kata: minimal " + $(this).attr("min-words") + " kata, maksimal " + $(
                this)
            .attr("max-words") + " kata");
    });


    // Add event trigger for change to textareas with limit
    $(document).on("input", "textarea[word-limit=true]", function() {

        // Get individual limits
        thisMin = parseInt($(this).attr("min-words"));
        thisMax = parseInt($(this).attr("max-words"));

        // Create array of words, skipping the blanks
        var removedBlanks = [];
        removedBlanks = $(this).val().split(/\s+/).filter(Boolean);

        // Get word count
        var wordCount = removedBlanks.length;

        // Remove extra words from string if over word limit
        if (wordCount > thisMax) {

            // Trim string, use slice to get the first 'n' values
            var trimmed = removedBlanks.slice(0, thisMax).join(" ");

            // Add space to ensure further typing attempts to add a new word (rather than adding to penultimate word)
            $(this).val(trimmed + " ");

        }


        // Compare word count to limits and print message as appropriate
        if (wordCount < thisMin) {

            $(this).parent().children(".writing_error").text("Word count under " + thisMin + ".");

        } else if (wordCount > thisMax) {

            $(this).parent().children(".writing_error").text("Word count over " + thisMax + ".");

        } else {

            // No issues, remove warning message
            $(this).parent().children(".writing_error").text("");

        }

    });
</script>
