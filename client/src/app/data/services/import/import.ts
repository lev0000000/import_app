import { HttpClient } from '@angular/common/http';
import { inject, Service } from '@angular/core';
import { Router } from '@angular/router';

@Service()
export class Import {
  http: HttpClient = inject(HttpClient);
  private router = inject(Router);

  baseApiUrl = 'http://localhost:8080';

  upload(file: File) {
    const formData = new FormData();
    formData.append('file', file);

    return this.http.post<{ jobId: string; status: string }>(`${this.baseApiUrl}/api/import`, formData)
  }
}
