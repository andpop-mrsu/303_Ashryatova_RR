#!/bin/bash
#pwsh -file make_db_init.ps1
sqlite3 movies_rating.db < db_init.sql
