<div style="font-family: sans-serif; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
    <h2 style="color: #001f3f;">Hello {{ $booking->name }},</h2>
    
    <p>Your booking status at <strong>{{ $booking->restaurant->name }}</strong> has been updated to:</p>
    
    <div style="display: inline-block; padding: 10px 20px; background: #e74c3c; color: #fff; font-weight: bold; border-radius: 5px; text-transform: uppercase;">
        {{ $booking->status }}
    </div>

    <p style="margin-top: 20px;">
        <strong>Date:</strong> {{ $booking->date }}<br>
        <strong>Time:</strong> {{ $booking->time }}<br>
        <strong>Guests:</strong> {{ $booking->guests }}
    </p>

    <p>Thank you for choosing FoodieBert!</p>

    <!-- --primary-blue: #0a192f;         
    --accent-gold: #C5A059;         
    --light-yellow: #fdf5e6;        
    --light-red: #e74c3c;           
    --dark-red: #b03a2e;     -->
</div>