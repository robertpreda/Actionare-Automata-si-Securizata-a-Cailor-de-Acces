package com.example.marius.poarta;

import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.widget.RemoteViews;

/**
 * Created by danny on 7/16/15.
 */
public class WidgetBroadcastReceiver extends BroadcastReceiver {
    public static final int COMMAND_OPEN = 0;
    public static final int COMMAND_CLOSE = 1;
    public static final int COMMAND_AUTO = 2;
    public static final int COMMAND_PAUSE = 3;

    @Override
    public void onReceive(Context context, Intent intent) {
        Log.d("App", intent.getAction());
        if(intent.getAction().equals(WidgetCommands.ACTION_OPEN)){
            sendCommand(context, COMMAND_OPEN);
        } else if(intent.getAction().equals(WidgetCommands.ACTION_CLOSE)) {
            sendCommand(context, COMMAND_CLOSE);
        } else if(intent.getAction().equals(WidgetCommands.ACTION_AUTO)) {
            sendCommand(context, COMMAND_AUTO);
        } else if(intent.getAction().equals(WidgetCommands.ACTION_PAUSE)) {
            sendCommand(context, COMMAND_PAUSE);
        }
        refreshWidget(context);
    }

    private void sendCommand(Context context, int commandType) {
        Communicator communicator = new Communicator(context, false);
        switch (commandType) {
            case COMMAND_OPEN:
                communicator.openGate();
                break;
            case COMMAND_CLOSE:
                communicator.closeGate();
                break;
            case COMMAND_AUTO:
                communicator.automaticGate();
                break;
            case COMMAND_PAUSE:
                communicator.pauseGate();
                break;
        }
    }

    private void refreshWidget(Context context) {
        RemoteViews remoteViews = new RemoteViews(context.getPackageName(), R.layout.widget_deschidere);
        remoteViews.setOnClickPendingIntent(R.id.bOpenW, buildButtonPendingIntent(context, R.id.bOpenW));
        remoteViews.setOnClickPendingIntent(R.id.bCloseW, buildButtonPendingIntent(context, R.id.bCloseW));
        remoteViews.setOnClickPendingIntent(R.id.bAutoW, buildButtonPendingIntent(context, R.id.bAutoW));
        remoteViews.setOnClickPendingIntent(R.id.bPauseW, buildButtonPendingIntent(context, R.id.bPauseW));

        WidgetCommands.pushWidgetUpdate(context.getApplicationContext(), remoteViews);
    }

    private PendingIntent buildButtonPendingIntent(Context context, int id) {
        return WidgetCommands.buildButtonPendingIntent(context, id);
    }
}
