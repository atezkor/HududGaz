package uz.tajriba.hududgaz2;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;


public class MainActivity extends AppCompatActivity implements View.OnClickListener {

    private Button btn_sys;
    private Button btn_doc;
    private Button btn_recovery;

    private ResultHandler handler;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        btn_sys = findViewById(R.id.system);
        btn_doc = findViewById(R.id.document);

        btn_sys.setOnClickListener(this);
        btn_doc.setOnClickListener(this);

        btn_recovery = findViewById(R.id.btn_recovery);
        handler = new ResultHandler(this, btn_recovery, btn_sys, btn_doc);
    }

    @Override
    public void onClick(View btn) {
        handler.btnClick((Button) btn);
        scanCode();
    }

    private void scanCode() {
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setCaptureActivity(CapActivity.class);
        integrator.setOrientationLocked(false);
        integrator.setDesiredBarcodeFormats(IntentIntegrator.QR_CODE_TYPES); // ALL_CODE_TYPES
        integrator.setPrompt(handler.getTitle());
        integrator.initiateScan();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if (result != null) {
            String content = result.getContents();
            if (content != null) {
                handler.resultCheck(result.getContents(), btn_sys, btn_doc);
                Toast.makeText(this, result.getContents(), Toast.LENGTH_SHORT).show();
            } else {
                AlertDialog.Builder builder = new AlertDialog.Builder(this);
                builder.setTitle("Natija yo\u2018q");
                builder.setPositiveButton("Qayta tekshirish", (dialogInterface, i) -> {
                    scanCode();
                });

                AlertDialog dialog = builder.create();
//                dialog.setCancelable(false);
                dialog.show();
            }
        } else {
            Toast.makeText(this, "Natija yo\u2018q", Toast.LENGTH_SHORT).show();
        }
    }
}