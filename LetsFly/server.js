const WebSocket = require('ws');


const wss = new WebSocket.Server({ port: 8080 });


let seats = [
    { seatId: 1, status: 'available' },
    { seatId: 2, status: 'available' },
    { seatId: 3, status: 'available' },
    { seatId: 4, status: 'available' },
    { seatId: 5, status: 'available' }
];


function broadcastUpdate(message) {
    wss.clients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(message));
        }
    });
}


wss.on('connection', (ws) => {
    console.log('New client connected');

    
    ws.send(JSON.stringify({ type: 'seatData', seats }));

    
    ws.on('message', (data) => {
        const message = JSON.parse(data);

        if (message.type === 'bookSeat') {
            
            const seat = seats.find(s => s.seatId === message.seatId);
            if (seat && seat.status === 'available') {
                seat.status = 'booked';
                broadcastUpdate({ type: 'seatUpdate', seat });
            }
        } else if (message.type === 'releaseSeat') {
            
            const seat = seats.find(s => s.seatId === message.seatId);
            if (seat && seat.status === 'booked') {
                seat.status = 'available';
                broadcastUpdate({ type: 'seatUpdate', seat });
            }
        }
    });

    
    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

console.log('WebSocket server is running on ws://localhost:8080');
