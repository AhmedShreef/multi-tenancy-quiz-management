<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Multitenancy Quiz Management</title>
    </head>
    <body>
        <h1>Welcome, {{ $data['member_name'] }}!</h1>
        <p>Thank you for taking time to submit quiz answers!</p>
        <p>Quiz title: {{ $data['quiz_title'] }}</p>
        <p>Your Score: {{ $data['member_score'] }}</p>
        <p>Total Score: {{ $data['total_score'] }}</p>
        <p>Best Regards, 
    </body>
</html>