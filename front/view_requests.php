<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>View Test Requests</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
      #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }

      #customers td,
      #customers th {
        border: 1px solid #ddd;
        padding: 8px;
      }

      #customers tr{
        background-color: #f2f2f2;
      }

      #customers tr:hover {
        background-color: #ddd;
      }

      #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4caf50;
        color: white;
      }
      body{
          background-color: rgb(157, 222, 242);
      }
    </style>
  </head>
  <body>
    <h1>Test Requests</h1>
    <table id="customers">
        <tr>
          <th>Doctor Name</th>
          <th>Patient Name</th>
          <th>Test Type</th>
          <th>Add Result</th>
        </tr>
        <tr>
          <td>Dr. Ali Vefa</td>
          <td>Hakan Kara</td>
          <td>Blood Test</td>
          <td><button>Add Result</button></td>
        </tr>
        <tr>
          <td>Dr. Tanju </td>
          <td>Selim Burak</td>
          <td>Urine Test</td>
          <td><button>Add Result</button></td>
        </tr>
      </table>
  </body>
</html>
