#!/bin/sh

URL="http://llmstack-router-service.default.svc.cluster.local/v1/models"

echo "<?php"
echo "return ["

curl -s "$URL" |
jq -r '.data[].id' |
while read -r model; do
    cat <<MODEL
    [
        'id' => '$model',
        'tools' => [
            'tool_calling' => true,
            'file_upload' => true,
            'vision' => true,
            'native_capabilities' => true,
        ],
    ],
MODEL
done

echo "];"
