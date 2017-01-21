#!/bin/bash

for COUNTER in `seq 1 35`
do
    nc -z crossbar-bundle.dev 54321;
    if [ $? = 0 ]; then
        exit 0;
    else
        echo "Waiting for Crossbar to be ready..."
        sleep 1;
    fi
done

echo "Crossbar IS NOT UP!"
exit 1;
