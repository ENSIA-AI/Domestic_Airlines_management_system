const axios = require('axios');
const fs = require('node:fs/promises');
const mysql = require('mysql2/promise');

/**
 * @typedef {object} FlightData
 * @property {object} aircraft
 * @property {string} aircraft.icao24 - 24-bit ICAO aircraft address (hex).
 * @property {string} aircraft.icaoCode - ICAO aircraft type designator (e.g., A332).
 * @property {string} aircraft.regNumber - Aircraft registration number (tail number).
 *
 * @property {object} airline
 * @property {string} airline.iataCode - IATA airline code (e.g., AH).
 * @property {string} airline.icaoCode - ICAO airline code (e.g., DAH).
 * @property {string} airline.name - Airline name (e.g., Air Algerie).
 *
 * @property {object} arrival
 * @property {?string} arrival.actualRunway - Actual runway time (ISO 8601 or null).
 * @property {?string} arrival.actualTime - Actual arrival time (ISO 8601 or null).
 * @property {?string} arrival.baggage - Baggage claim information (or null).
 * @property {?string} arrival.delay - Arrival delay in minutes (string) or null.
 * @property {?string} arrival.estimatedRunway - Estimated runway time (ISO 8601 or null).
 * @property {?string} arrival.estimatedTime - Estimated arrival time (ISO 8601 or null).
 * @property {?string} arrival.gate - Arrival gate number (or null).
 * @property {string} arrival.iataCode - IATA airport code for arrival (e.g., GHA).
 * @property {string} arrival.icaoCode - ICAO airport code for arrival (e.g., DAUG).
 * @property {string} arrival.scheduledTime - Scheduled arrival time (ISO 8601).
 * @property {?string} arrival.terminal - Arrival terminal (or null).
 *
 * @property {?any} codeshared - Codeshare information (or null).
 *
 * @property {object} departure
 * @property {?string} departure.actualRunway - Actual runway time (ISO 8601 or null).
 * @property {string} departure.actualTime - Actual departure time (ISO 8601).
 * @property {?string} departure.baggage - Baggage information (or null).
 * @property {string} departure.delay - Departure delay in minutes (string).
 * @property {string} departure.estimatedRunway - Estimated runway time (ISO 8601).
 * @property {?string} departure.estimatedTime - Estimated departure time (ISO 8601 or null).
 * @property {?string} departure.gate - Departure gate number (or null).
 * @property {string} departure.iataCode - IATA airport code for departure (e.g., ALG).
 * @property {string} departure.icaoCode - ICAO airport code for departure (e.g., DAAG).
 * @property {string} departure.scheduledTime - Scheduled departure time (ISO 8601).
 * @property {string} departure.terminal - Departure terminal.
 *
 * @property {object} flight
 * @property {string} flight.iataNumber - IATA flight number (e.g., AH6530).
 * @property {string} flight.icaoNumber - ICAO flight number (e.g., DAH6530).
 * @property {string} flight.number - Flight number (e.g., 6530).
 *
 * @property {string} status - Flight status (e.g., "active").
 * @property {string} type - Flight type (e.g., "departure").
 */

/**
 * @typedef {object} FlightResponse
 * @property {object} pagination
 * @property {?number} pagination.limit
 * @property {?number} pagination.offset
 * @property {number} pagination.count - Number of items in the current 'data' array.
 * @property {number} pagination.total - Total number of items available.
 * @property {FlightData[]} data - Array of flight data objects.
 */

async function connectToDb() {
    const configFile = await fs.readFile("db_config.json", 'utf-8');
    const config = JSON.parse(configFile);
    return await mysql.createConnection(config);
}

/** 
*@param {FlightData[]} data
* @param {string[]} algerianAirports 
**/
function filterLocalFlights(data, algerianAirports) {
    return data.filter((flight) => {
        return algerianAirports.includes(flight.arrival.iataCode);
    });
}

/** 
*@param {mysql.Connection} connection
**/
async function getAlgerianAirports(connection) {
    const [rows, fields] = await connection.execute('SELECT IATA_CODE FROM AIRPORTS');
    const res = Array(rows.length);
    rows.forEach((element, i) => {
        res[i] = element.IATA_CODE;
    });

    return res;
}

/** 
*@param {mysql.Connection} connection
* @param {FlightData[]} data 
**/
async function insertFlights(connection, data) {
    const newFlights = [];

    const sql = "INSERT INTO FLIGHTS (FLIGHT_NUMBER, DEPARTURE_TIME, DURATION, DEP_AIRPORT, ARR_AIRPORT, STATUS, AIRCRAFT) VALUES ?";
    data.forEach((flight) => {
        newFlights.push([flight.flight.iataNumber, flight.departure.scheduledTime, 120, flight.departure.iataCode, flight.arrival.iataCode, 'SCHEDULED', null]);
    });

    connection.query(sql, [newFlights], (err, results) => {
        if (err) throw err;
        console.log(`Inserted ${results.affectedRows} rows.`);
    });
}


const depAirport = "ALG";

axios.get(`https://api.aviationstack.com/v1/timetable`, {
    params: {
        access_key: process.env.API_KEY,
        iataCode: depAirport,
        date: "2025-12-04",
        type: "departure"
    }
})
    .then((response) => {
        let res = response.data;

        connectToDb().then((connection) => {
            getAlgerianAirports(connection).then((airports) => {
                insertFlights(connection, filterLocalFlights(res.data, airports));
                connection.end();
            });
        });
    }).catch(e => {
        console.log(e);
    });

