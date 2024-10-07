<section id="orders">
            <h2>Order Management</h2>
            <h3>All Orders</h3>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Items</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($allOrders) > 0) {
                        while ($row = mysqli_fetch_assoc($allOrders)) {
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['items']}</td>
                                    <td>{$row['status']}</td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>