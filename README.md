<h1>Seleksi Tenaga Ahli Diskominfo Jatim</h1>

<h2>Table of Contents</h2>
<ul>
    <li><a href="#introduction">Introduction</a></li>
    <li><a href="#requirements">Requirements</a></li>
    <li><a href="#installation">Installation</a></li>
    <li><a href="#running-the-project">Running the Project</a></li>
    <li><a href="#api-endpoints">API Endpoints</a>
        <ul>
            <li><a href="#products">Products</a></li>
            <li><a href="#orders">Orders</a></li>
        </ul>
    </li>
    <li><a href="#testing-api-with-postman">Testing API with Postman</a></li>
</ul>

<h2 id="introduction">Introduction</h2>
<p>This is a simple API built using <strong>Laravel 9</strong> for managing products and orders.</p>

<h2 id="requirements">Requirements</h2>
<p>Ensure that the following software is installed on your machine:</p>
<ul>
    <li>PHP >= 8.0</li>
    <li>Composer : <a href="https://getcomposer.org/download/">https://getcomposer.org/download/</a></p></li>
    <li>MySQL database</li>
    <li>Xampp : <a href="https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.28/">https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.0.28/</a></p></li>
    <li>Postman (for testing the API)</li>
</ul>

<h2 id="installation">Installation</h2>

<ol>
    <li><strong>Clone the Repository</strong>
        <pre>
        git clone https://github.com/username/your-repo.git
        cd your-repo
        </pre>
    </li>
    <li><strong>Install Composer Dependencies</strong>
        <pre>
        composer install
        </pre>
    </li>
    <li><strong>Set Up Environment Variables</strong>
        <p>Copy the example .env file:</p>
        <pre>
        cp .env.example .env
        </pre>
        <p>Open the .env file in any text editor and configure the database settings:</p>
        <pre>
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password
        </pre>
    </li>
    <li><strong>Generate Application Key</strong>
        <pre>
        php artisan key:generate
        </pre>
    </li>
    <li><strong>Run Database Migrations</strong>
        <pre>
        php artisan migrate
        </pre>
    </li>
</ol>

<h2 id="running-the-project">Running the Project</h2>
<ol>
    <li>Start the Laravel development server:
        <pre>
        php artisan serve
        </pre>
    </li>
    <li>The API will be running at <code>http://127.0.0.1:8000</code>. You can now test the endpoints using <strong>Postman</strong>.</li>
</ol>

<h2 id="api-endpoints">API Endpoints</h2>

<h3 id="products">List Products</h3>
<ul>
    <li><strong>Method:</strong> GET</li>
    <li><strong>URL:</strong> /api/products</li>
</ul>

<h3 id="products">Create Products</h3>
<ul>
    <li><strong>Method:</strong> POST</li>
    <li><strong>URL:</strong> /api/products</li>
</ul>

<h3 id="products">Detail Products</h3>
<ul>
    <li><strong>Method:</strong> GET</li>
    <li><strong>URL:</strong> /api/products/{id}</li>
</ul>

<h3 id="products">Update Products</h3>
<ul>
    <li><strong>Method:</strong> PUT</li>
    <li><strong>URL:</strong> /api/products/{id}</li>
</ul>

<h3 id="products">Delete Products</h3>
<ul>
    <li><strong>Method:</strong> DELETE</li>
    <li><strong>URL:</strong> /api/products/{id}</li>
</ul>

<h3 id="orders">List Orders</h3>
<ul>
    <li><strong>Method:</strong> GET</li>
    <li><strong>URL:</strong> /api/orders</li>
</ul>

<h3 id="create-order">Create Order</h3>
<ul>
    <li><strong>Method:</strong> POST</li>
    <li><strong>URL:</strong> /api/orders</li>
</ul>

<h3 id="orders">Detail Orders</h3>
<ul>
    <li><strong>Method:</strong> GET</li>
    <li><strong>URL:</strong> /api/orders/{id}</li>
</ul>

<h3 id="delete-order">Delete Order</h3>
<ul>
    <li><strong>Method:</strong> DELETE</li>
    <li><strong>URL:</strong> /api/orders/{id}</li>
</ul>

<h2 id="testing-api-with-postman">Testing API with Postman</h2>
<ol>
    <li><strong>Install Postman</strong>
        <p>Download and install Postman from the official website: <a href="https://www.postman.com/downloads/">https://www.postman.com/downloads/</a></p>
    </li>
    <li><strong>Open Postman</strong>
        <p>Once Postman is installed, open the application.</p>
    </li>
    <li><strong>Create a New Request</strong>
        <p>To test the API, create a new request in Postman by clicking the <strong>New</strong> button and selecting <strong>HTTP Request</strong>.</p>
    </li>
    <li><strong>Set the Request Method and URL</strong>
        <p>For example, to list all products:</p>
        <pre>
Set method to GET
Set URL to http://127.0.0.1:8000/api/products
        </pre>
        <p>Then, click <strong>Send</strong>.</p>
    </li>
    <li><strong>Check the Response</strong>
        <p>You should see a response similar to the one described in the <a href="#list-products">List Products</a> section. If the API returns the expected data, it means your API is working correctly.</p>
    </li>
</ol>
