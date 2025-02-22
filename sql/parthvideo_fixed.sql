-- PostgreSQL Table Structure for Database "parthvideo"
-- This script creates only the table structures, no data is inserted.

-- Table: bookings
CREATE TABLE bookings (
    bookingid SERIAL PRIMARY KEY,
    eventid INTEGER NOT NULL,
    title VARCHAR NOT NULL,
    fullname VARCHAR NOT NULL,
    username VARCHAR NOT NULL,
    items TEXT NOT NULL,
    status VARCHAR NOT NULL
);

-- Table: devices
CREATE TABLE devices (
    deviceid SERIAL PRIMARY KEY,
    devicename VARCHAR,
    devicedesc TEXT,
    deviceimage TEXT,
    fullname VARCHAR,
    userid INTEGER
);

-- Table: events
CREATE TABLE events (
    eventid SERIAL PRIMARY KEY,
    title VARCHAR NOT NULL,
    date DATE NOT NULL,
    venue VARCHAR NOT NULL,
    capacity INTEGER NOT NULL,
    eventimage VARCHAR
);

-- Table: team
CREATE TABLE team (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    role VARCHAR NOT NULL,
    photo VARCHAR NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table: users
CREATE TABLE users (
    userid SERIAL PRIMARY KEY,
    fullname VARCHAR NOT NULL,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    avatar VARCHAR,
    level INTEGER DEFAULT 0
);


sink 400
shower 79
exposed 


02087347219 Avinash
