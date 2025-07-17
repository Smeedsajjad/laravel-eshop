<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>New Contact Request</title>
  <style>
    .header {
      background: #6133BD;
      color: white;
      padding: 1rem;
      text-align: center;
    }
    .panel {
      border: 1px solid #ddd;
      padding: 1rem;
      margin: 1rem 0;
    }
    .button {
      display: inline-block;
      background: #6133BD;
      color: white;
      padding: 0.75rem 1.25rem;
      text-decoration: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>📨 New Contact Request</h1>
  </div>

  <div class="panel">
    <p><strong>👤 Name:</strong> {{ $name }}</p>
    <p><strong>✉️ Email:</strong> {{ $email }}</p>
    <p><strong>📌 Subject:</strong> {{ $subject }}</p>
  </div>

  <div class="body">
    <p>{!! nl2br(e($body)) !!}</p>
  </div>

  <p style="text-align:center">
    <a href="{{ config('app.url') }}" class="button">
      Visit Our Site
    </a>
  </p>

  <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
