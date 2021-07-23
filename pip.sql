SELECT
    b.pipol_code AS "PIPOL Code",
    a.title AS "PAP Title",
    c.name AS "Program or Project",
    d.name AS "Spatial Coverage",
    e.name AS "Main PDP Chapter",
    f.name AS "Main Funding Source",
    g.name AS "Mode of Implementation",
    a.target_start_year AS "Start Year",
    a.target_end_year AS "Completion Year",
    h.name AS "Status",
    SUM(i.y2016) AS "2016 and Prior",
    SUM(i.y2017) AS "2017",
    SUM(i.y2018) AS "2018",
    SUM(i.y2019) AS "2019",
    SUM(i.y2020) AS "2020",
    SUM(i.y2021) AS "2021",
    SUM(i.y2022) AS "2022",
    SUM(i.y2023) AS "2023 and Beyond"
FROM projects a
         INNER JOIN pipols b ON a.id=b.ipms_id
         LEFT JOIN pap_types c ON a.pap_type_id=c.id
         LEFT JOIN spatial_coverages d ON a.spatial_coverage_id=d.id
         LEFT JOIN pdp_chapters e ON a.pdp_chapter_id=e.id
         LEFT JOIN funding_sources f ON a.funding_source_id=f.id
         LEFT JOIN implementation_modes g ON a.implementation_mode_id=g.id
         LEFT JOIN project_statuses h ON a.project_status_id=h.id
         LEFT JOIN fs_investments i ON a.id=i.project_id
WHERE b.submission_status="Endorsed"
  AND b.category<>"Dropped"
GROUP BY a.id