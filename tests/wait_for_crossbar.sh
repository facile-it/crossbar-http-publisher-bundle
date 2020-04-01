#!/bin/bash

for COUNTER in `seq 1 30`
do
    curl -X POST -H "Content-Type: application/json" -s http://localhost:54321/publish > /dev/null;
    if [ $? = 0 ]; then
        echo "Crossbar seems to be up and responding!"
        exit 0;
    else
        echo "Waiting for Crossbar to be ready..."
        sleep 1;
    fi
done

echo "Crossbar IS NOT UP!"
exit 1;
