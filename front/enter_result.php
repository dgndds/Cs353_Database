<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Enter Result</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
      body {
        background-color: rgb(157, 222, 242);
      }
      h1 {
        text-align: center;
      }
      div {
        margin-top: 5%;
        margin-left: 40%;
        margin-right: 40%;
        border: 4px solid;
        background-color: wheat;
      }
      h4 {
        margin-left: 5px;
      }
      button {
        background-color: #eb2f3f;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 10px;
        cursor: pointer;
      }
      button:active {
        background-color: #810606;
      }
    </style>
  </head>
  <body>
    <h1>Test Result</h1>
    <div>
      <h4>Patient Name: Hakan Kara</h4>
      <h4>Test: Blood Test</h4>
      <h4>
        Magnesium:
        <select name="test values" id="test value">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </h4>
      <h4>
        Calcium:
        <select name="test values" id="test value">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </h4>
      <button style="margin-left: 25%; margin-bottom: 5px">
        Submit Results
      </button>
    </div>
  </body>
</html>
