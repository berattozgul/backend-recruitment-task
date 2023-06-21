<?php
// Read users from JSON file
$usersJson = file_get_contents('dataset/users.json');
$users = json_decode($usersJson, true);

// Check if the form is submitted to add a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['street'], $_POST['city'], $_POST['zipcode'], $_POST['phone'], $_POST['company'], $_POST['catchphrase'], $_POST['bs'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $zipcode = $_POST['zipcode'];
    $phone = $_POST['phone'];
    $companyName = $_POST['company'];
    $catPhrase = $_POST['catchphrase'];
    $bs = $_POST['bs'];

    // Validate form data
    if (empty($name) || empty($username) || empty($email) || empty($street) || empty($city) || empty($zipcode) || empty($phone) || empty($companyName) || empty($catPhrase) || empty($bs)) {
        echo "Please fill in all the required fields.";
        exit;
    }

    // Create a new user object
    $newUser = [
        'id' => count($users) + 1,
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'address' => [
            'street' => $street,
            'city' => $city,
            'zipcode' => $zipcode
        ],
        'phone' => $phone,
        'company' => [
            'name' => $companyName,
            'catchPhrase' => $catPhrase,
            'bs' => $bs
        ]
    ];

    // Add the new user to the users array
    $users[] = $newUser;

    // Save the updated users array back to the JSON file
    file_put_contents('dataset/users.json', json_encode($users));

    // Redirect to refresh the page and display the updated user list
    header('Location: index.php');
    exit;
}

// Check if the remove user button is clicked
if (isset($_POST['removeUser'])) {
    $userId = $_POST['removeUser'];

    // Remove the user from the users array based on the ID
    unset($users[$userId]);

    // Re-index the array to fix the keys
    $users = array_values($users);

    // Save the updated users array back to the JSON file
    file_put_contents('dataset/users.json', json_encode($users));

    // Redirect to refresh the page and display the updated user list
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>User Management</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Company</th>
                <th></th>
            </tr>
            <?php foreach ($users as $id => $user): ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['address']['street'] . ', ' . $user['address']['city'] . ', ' . $user['address']['zipcode']; ?></td>
                    <td><?php echo $user['phone']; ?></td>
                    <td>
                        <button class="btn btn-primary company-button"><?php echo $user['company']['name']; ?></button>
                        <div class="company-details" style="display: none;">
                            <p><strong>Catchphrase:</strong> <?php echo $user['company']['catchPhrase']; ?></p>
                            <p><strong>BS:</strong> <?php echo $user['company']['bs']; ?></p>
                        </div>
                    </td>
                    <td>
                        <form method="post" onsubmit="return confirm('Are you sure you want to remove this user?');">
                            <input type="hidden" name="removeUser" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-danger remove-button">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h1>Add User</h1>
        <form method="post">
            <div class="form-row">
                <div class="col">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="zipcode">Zip Code:</label>
                    <input type="text" class="form-control" name="zipcode" required>
                </div>
                <div class="col">
                    <label for="street">Street:</label>
                    <input type="text" class="form-control" name="street" required>
                </div>
                <div class="col">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" name="city" required>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>
                <div class="col">
                    <label for="company">Company Name:</label>
                    <input type="text" class="form-control" name="company" required>
                </div>
                <div class="col">
                    <label for="catchphrase">Catchphrase:</label>
                    <input type="text" class="form-control" name="catchphrase" required>
                </div>
                <div class="col">
                    <label for="bs">BS:</label>
                    <input type="text" class="form-control" name="bs" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary add-button">Add User</button>

        </form>
    </div>

    <script src="path/to/bootstrap.js"></script>
    <script src="scripts.js"></script>
</body>
</html>
