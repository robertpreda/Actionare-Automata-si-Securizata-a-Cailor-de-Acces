package com.example.marius.poarta;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.preference.PreferenceManager;
import android.util.Log;
import android.widget.RemoteViews;
import android.widget.Toast;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;

import java.io.IOException;

/**
 * Created by danny on 7/16/15.
 */
public class Communicator {
    public static final String GATE_OPEN_FINAL_CODE = "1";
    public static final String GATE_CLOSE_FINAL_CODE = "2";
    public static final String GATE_AUTOMATIC_FINAL_CODE = "3";
    public static final String GATE_PAUSE_FINAL_CODE = "4";

    GateAction gateAction = GateAction.GATE_SLEEP;

    Context context;
    ProgressDialog dialog;

    private String urlRandomString;
    private String urlSendCommand;
    private String randomString;
    private String usernameAndPassword;
    private String ip, port, username, password;
    private boolean fromActivity;

    private enum GateAction {
        GATE_SLEEP, GATE_OPEN, GATE_CLOSE, GATE_AUTOMATIC, GATE_PAUSE
    }

    public Communicator(Context context, boolean fromActivity) {
        try {
            SharedPreferences sp = PreferenceManager.getDefaultSharedPreferences(context.getApplicationContext());
            ip = sp.getString("ip", "");
            port = sp.getString("port", "");
            username = sp.getString("username", "");
            password = sp.getString("password", "");
            urlRandomString = "http://" + ip + ":" + port + "/test/test.php";
            urlSendCommand = "http://" + ip + ":" + port + "/test/cineIntra.php?user=" + username + "&token=";
            //valori temporare pentru webserverul meu
            //urlRandomString = "http://" + ip + ":" + port + "/random.php";
            //urlSendCommand = "http://" + ip + ":" + port + "/index.php?user=" + username + "&token=";
            usernameAndPassword = username + password;

            this.context = context;
            this.fromActivity = fromActivity;
            showMessage("Constructor");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void openGate() {
        showMessage("Open Gate");
        gateAction = GateAction.GATE_OPEN;
        performGateCommand();
    }

    public void closeGate() {
        gateAction = GateAction.GATE_CLOSE;
        performGateCommand();
    }

    public void automaticGate() {
        gateAction = GateAction.GATE_AUTOMATIC;
        performGateCommand();
    }

    public void pauseGate() {
        gateAction = GateAction.GATE_PAUSE;
        performGateCommand();
    }

    private void performGateCommand() {
        if(isNetworkAvailable()) {
            showMessage("Network available");
            new PostRequest().execute();
        } else {
            makeError("Nu sunteti conectat la o retea de date mobile sau wifi!");
        }
    }

    public void setUrlRandomString(String urlRandomString) {
        this.urlRandomString = urlRandomString;
    }

    public void setUrlSendCommand(String urlSendCommand) {
        this.urlSendCommand = urlSendCommand;
    }

    public void setUsernameAndPassword(String usernameAndPassword) {
        this.usernameAndPassword = usernameAndPassword;
    }

    public String getIp() {
        return ip;
    }

    public String getPort() {
        return port;
    }

    public String getUsername() {
        return username;
    }

    public String getPassword() {
        return password;
    }

    public String MD5(String md5) {
        try {
            java.security.MessageDigest md = java.security.MessageDigest.getInstance("MD5");
            byte[] array = md.digest(md5.getBytes());
            StringBuffer sb = new StringBuffer();
            for (int i = 0; i < array.length; ++i) {
                sb.append(Integer.toHexString((array[i] & 0xFF) | 0x100).substring(1, 3));
            }
            return sb.toString();
        } catch (java.security.NoSuchAlgorithmException e) {
        }
        return null;
    }

    private class PostRequest extends AsyncTask<Void, Void, Void> {
        @Override
        protected void onPreExecute() {
            showMessage("Preparing");
            if(fromActivity) {
                dialog = new ProgressDialog(context);
                dialog.setIndeterminate(true);
                dialog.setTitle("Loading...");
                dialog.show();
            }
        }

        @Override
        protected Void doInBackground(Void... params) {
            try {
                showMessage("Getting Random String");
                Document document;
                document = Jsoup.connect(urlRandomString).timeout(15000).get();
                Element body = document.body();
                randomString = body.text();
                showMessage("Got random string");

                String gateCommand =  usernameAndPassword + randomString;
                String commandType = "";
                switch (gateAction) {
                    case GATE_OPEN:
                        gateCommand += GATE_OPEN_FINAL_CODE;
                        commandType = "O";
                        break;
                    case GATE_CLOSE:
                        gateCommand += GATE_CLOSE_FINAL_CODE;
                        commandType = "C";
                        break;
                    case GATE_AUTOMATIC:
                        gateCommand += GATE_AUTOMATIC_FINAL_CODE;
                        commandType = "A";
                        break;
                    case GATE_PAUSE:
                        gateCommand += GATE_PAUSE_FINAL_CODE;
                        commandType = "P";
                        break;
                }
                String urlWithCommand = urlSendCommand + MD5(gateCommand);
                //pentru debugging
                //urlWithCommand += "&commandType="+commandType;
                showMessage("Sending Request");
                Jsoup.connect(urlWithCommand).get();
                showMessage("Sent request");
            } catch (IOException e) {
                e.printStackTrace();
            }
            return null;
        }

        @Override
        protected void onPostExecute(Void aVoid) {
            if(fromActivity) {
                if (dialog.isShowing()) {
                    dialog.dismiss();
                }
            } else {
                RemoteViews remoteViews = new RemoteViews(context.getPackageName(), R.layout.widget_deschidere);
                WidgetCommands.pushWidgetUpdate(context.getApplicationContext(), remoteViews);
            }
            gateAction = GateAction.GATE_SLEEP;
        }
    }

    private boolean isNetworkAvailable() {
        showMessage("Checking connectivity");
        ConnectivityManager connectivityManager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }

    private void makeError(String message) {
        Toast.makeText(context, message, Toast.LENGTH_LONG);
    }

    private void showMessage(String message) {
        Log.d("Communicator", message);
    }
}
