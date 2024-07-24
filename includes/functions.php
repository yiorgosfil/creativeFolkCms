<?php
// Database Connection
function pdo(PDO $pdo, string $sql, array $arguments = null)
{
    if (!$arguments) {
        return $pdo->query($sql); // Run SQL and return PDOStatement object
    }
    $statement = $pdo->prepare($sql);
    $statement->execute($arguments);
    return $statement;
}

// Formatting Functions
function html_escape($text): string
{
    // If the value passed into the function is null, set $text to an empty string
    $text = $text ?? '';

    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
}

function format_date(string $string): string
{
    $date = date_create_from_format('Y-m-d H:i:s', $string); // Convert to DateTime object
    return $date->format('F d, Y');                          // Return in format Jan 31, 2030
}

// Error and Exception Handling Functions
// Convert errors to exceptions
set_error_handler('handle_error');
function handle_error($error_type, $error_message, $error_file, $error_line)
{
    // Turn into ErrorException
    throw new ErrorException($error_message, 0, $error_type, $error_file, $error_line);
}

// Handle exceptions, log exception and show error message,
// if the server does not send error page listed in .htaccess
function handle_exception($e)
{
    error_log($e); // Log the error
    http_response_code(500); // Set the http response code
    echo "<h2>Sorry, a problem occured</h2>
          <p>The site's owners have been informed. Please try again later.</p>";
}

// Handle fatal errors
register_shutdown_function('handle_shutdown');
function handle_shutdown()
{
    $error = error_get_last(); // Check for error in script
    if ($error !== null) {
        $e = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        handle_exception($e); // Call exception handler
    }
}
