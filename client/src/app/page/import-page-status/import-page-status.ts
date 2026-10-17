import { HttpClient } from '@angular/common/http';
import { Component, inject, OnInit, OnDestroy } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {
  Subscription,
  interval,
  startWith,
  switchMap,
  takeWhile
} from 'rxjs';

@Component({
  imports: [],
  selector: 'app-import-page-status',
  styleUrl: './import-page-status.css',
  templateUrl: './import-page-status.html',
})
export class ImportPageStatus {
  private route = inject(ActivatedRoute);
  private http = inject(HttpClient);

  private request?: Subscription;
  baseApiUrl = 'http://localhost:8080';

  status = 'pending'  

  ngOnInit() {
    const jobId = this.route.snapshot.paramMap.get('id');

    this.request = interval(2000)
      .pipe(
        startWith(0),
        switchMap(() =>
          this.http.get<{jobId : string}>(`${this.baseApiUrl}/api/import/${jobId}/status`)
        )
      )
      .subscribe(response => {
        console.log(response);
      });
    }

  }
